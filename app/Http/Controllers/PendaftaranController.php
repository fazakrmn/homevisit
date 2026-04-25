<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class PendaftaranController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$clientKey    = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    public function step1()
    {
        return view('pendaftaran.form');
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:12',
            'alamat' => 'required|string',
            'nik' => 'required|string|size:16|unique:pendaftarans,nik',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date|before:today',
            'permasalahan' => 'required|string',
            'tanggal_konsultasi' => 'required|date|after:today',
            'waktu_konsultasi' => 'required',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'no_telepon.required' => 'No. Telepon wajib diisi',
            'no_telepon.max' => 'No. Telepon maksimal 12 karakter',
            'alamat.required' => 'Alamat wajib diisi',
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
        ]);

        $pendaftaran = Pendaftaran::create([
            'nama' => $validated['nama'],
            'no_telepon' => $validated['no_telepon'],
            'alamat' => $validated['alamat'],
            'nik' => $validated['nik'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'status_pendaftaran' => 'pending',
            'permasalahan' => $validated['permasalahan'],
            'tanggal_konsultasi' => $validated['tanggal_konsultasi'],
            'waktu_konsultasi' => $validated['waktu_konsultasi'],
            'status_step' => 'step1',
        ]);

        return redirect()->route('pendaftaran.step2', $pendaftaran->id)
                        ->with('success', 'Data berhasil disimpan. Silakan lanjutkan ke tahap berikutnya.');
    }

    public function step2($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        return view('pendaftaran.pilihdokter', compact('pendaftaran'));
    }

    public function storeStep2(Request $request, $id)
    {
        $validated = $request->validate([
            'dokter' => 'required|string|max:255',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update([
            'dokter' => $validated['dokter'],
            'total_amount' => 100000,
            'status_step' => 'step2',
        ]);

        return redirect()->route('pendaftaran.step3', $id)
                        ->with('success', 'Jadwal berhasil dipilih.');
    }

    public function step3($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        // Create Midtrans order and get snap token
        $orderId = 'ORDER-' . $id . '-' . uniqid();
        
        $pendaftaran->update([
            'order_id' => $orderId,
            'status' => 'pending',
        ]);

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $pendaftaran->total_amount,
            ],
            'customer_details' => [
                'first_name' => $pendaftaran->nama,
            ],
            'item_details' => [
                [
                    'id'       => 'homevisit-' . $id,
                    'price'    => (int) $pendaftaran->total_amount,
                    'quantity' => 1,
                    'name'     => 'Layanan Home Visit',
                ],
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $pendaftaran->update(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            $snapToken = null;
        }

        return view('pendaftaran.pembayaran', compact('pendaftaran', 'snapToken'));
    }

    public function storeStep3(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        $pendaftaran->update([
            'pembayaran' => $request->pembayaran,
            'status_step' => 'step3',
        ]);

        return redirect()->route('pendaftaran.step4', $id)
                        ->with('success', 'Pembayaran berhasil diproses.');
    }

    public function step4($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        return view('pendaftaran.dokumen', compact('pendaftaran'));
    }

    public function storeStep4(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        $pendaftaran->update([
            'status_step' => 'selesai',
            'status_pendaftaran' => 'selesai'
        ]);

        return redirect()->route('pendaftaran.sukses', $id)
                        ->with('success', 'Pendaftaran berhasil! Data Anda sedang diproses.');
    }

    public function sukses($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        return view('pendaftaran.sukses', compact('pendaftaran'));
    }

    public function index()
    {
        $pendaftarans = Pendaftaran::latest()->paginate(10);
        return view('pendaftaran.index', compact('pendaftarans'));
    }

    public function show($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        return view('pendaftaran.show', compact('pendaftaran'));
    }
}