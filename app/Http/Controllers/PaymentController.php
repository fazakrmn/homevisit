<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$clientKey    = config('midtrans.client_key');
        Config::$isProduction = false;
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    // Buat Snap Token untuk pembayaran
    public function createTransaction(Request $request)
    {
        $order = Order::create([
            'order_id'     => 'ORDER-' . uniqid(),
            'user_id'      => auth()->id(),
            'total_amount' => $request->amount,
            'status'       => 'pending',
        ]);

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_id,
                'gross_amount' => $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email'      => auth()->user()->email,
            ],
            'item_details' => $request->items ?? [],
        ];

        $snapToken = Snap::getSnapToken($params);

        $order->update(['snap_token' => $snapToken]);

        return response()->json([
            'snap_token' => $snapToken,
            'order_id'   => $order->order_id,
            'client_key' => config('midtrans.client_key'),
        ]);
    }

    // Handle Webhook/Notification dari Midtrans
    public function notification(Request $request)
    {
        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $orderId           = $notification->order_id;
        $fraudStatus       = $notification->fraud_status;

        // Cek di tabel Pendaftaran terlebih dahulu
        $pendaftaran = Pendaftaran::where('order_id', $orderId)->first();
        if ($pendaftaran) {
            if ($transactionStatus == 'capture') {
                $pendaftaran->status = ($fraudStatus == 'accept') ? 'paid' : 'failed';
            } elseif ($transactionStatus == 'settlement') {
                $pendaftaran->status = 'paid';
                $pendaftaran->status_step = 'selesai';
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $pendaftaran->status = 'failed';
            } elseif ($transactionStatus == 'pending') {
                $pendaftaran->status = 'pending';
            }
            $pendaftaran->save();

            return response()->json(['message' => 'Notification handled for Pendaftaran']);
        }

        // Jika bukan dari Pendaftaran, cek tabel Order
        $order = Order::where('order_id', $orderId)->first();
        if ($order) {
            if ($transactionStatus == 'capture') {
                $order->status = ($fraudStatus == 'accept') ? 'paid' : 'failed';
            } elseif ($transactionStatus == 'settlement') {
                $order->status = 'paid';
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $order->status = 'failed';
            } elseif ($transactionStatus == 'pending') {
                $order->status = 'pending';
            }
            $order->save();
        }

        return response()->json(['message' => 'Notification handled']);
    }

    // Handle Frontend Callback (Redirect) dari Midtrans
    public function callback(Request $request)
    {
        $orderId = $request->order_id;
        $transactionStatus = $request->transaction_status;

        if (!$orderId) {
            return redirect()->route('index')->with('error', 'Order ID tidak valid.');
        }

        // Cek Pendaftaran
        $pendaftaran = Pendaftaran::where('order_id', $orderId)->first();
        if ($pendaftaran) {
            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                return redirect()->route('pendaftaran.sukses', $pendaftaran->id)->with('success', 'Pembayaran Berhasil!');
            } elseif ($transactionStatus == 'pending') {
                return redirect()->route('pendaftaran.step3', $pendaftaran->id)->with('warning', 'Menunggu Pembayaran diselesaikan.');
            } else {
                return redirect()->route('pendaftaran.step3', $pendaftaran->id)->with('error', 'Pembayaran Gagal atau Dibatalkan.');
            }
        }

        return redirect()->route('index')->with('success', 'Transaksi Selesai');
    }
}