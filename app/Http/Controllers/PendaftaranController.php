<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller
{
    public function step1()
    {
        return view('pendaftaran.step1');
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
            'status_step' => 'step2',
         ]);

        return redirect()->route('pendaftaran.step3', $id)
                        ->with('success', 'Jadwal berhasil dipilih.');
    }

    public function step3($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        return view('pendaftaran.pembayaran', compact('pendaftaran'));
    }

    public function storeStep3(Request $request, $id)
    {
        $validated = $request->validate([
            'pembayaran' => 'required|string',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update([
            'pembayaran' => $validated['pembayaran'],
            'status_step' => 'step3',
        ]);

        return redirect()->route('pendaftaran.step4', $id)
                        ->with('success', 'Pembayaran berhasil disimpan.');
    }

    // Tampilkan form step 4
    public function step4($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        return view('pendaftaran.dokumen', compact('pendaftaran'));
    }

    // Proses step 4 (upload dokumen)
    public function storeStep4(Request $request, $id)
    {
        $validated = $request->validate([
            // 'dokumen_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            // 'dokumen_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);

        // // Upload dokumen KTP
        // if ($request->hasFile('dokumen_ktp')) {
        //     $ktpPath = $request->file('dokumen_ktp')->store('dokumen/ktp', 'public');
        //     $pendaftaran->dokumen_ktp = $ktpPath;
        // }

        // // Upload dokumen pendukung (opsional)
        // if ($request->hasFile('dokumen_pendukung')) {
        //     $pendukungPath = $request->file('dokumen_pendukung')->store('dokumen/pendukung', 'public');
        //     $pendaftaran->dokumen_pendukung = $pendukungPath;
        // }

        $pendaftaran->update([
            'status_step' => 'selesai',
            'status_pendaftaran' => 'pending'
        ]);

        return redirect()->route('pendaftaran.sukses', $id)
                        ->with('success', 'Pendaftaran berhasil! Data Anda sedang diproses.');
    }

    // Halaman sukses
    public function sukses($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        return view('pendaftaran.sukses', compact('pendaftaran'));
    }

    // List semua pendaftaran (untuk admin)
    public function index()
    {
        $pendaftarans = Pendaftaran::latest()->paginate(10);
        return view('pendaftaran.form', compact('pendaftarans'));
    }

    // Detail pendaftaran
    public function show($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        return view('pendaftaran.show', compact('pendaftaran'));
    }
}