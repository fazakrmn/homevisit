<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{   

    public function index()
    {
        // Ambil semua data pendaftaran dari database
        $pendaftarans = Pendaftaran::all();
        // Hitung statistik
        $totalUsers = Pendaftaran::count();
        $activeUsers = Pendaftaran::where('status_pendaftaran', 'approved')->count();
        $inactiveUsers = Pendaftaran::where('status_pendaftaran', 'draft')->count();
        
        return view('dashboard', compact('pendaftarans', 'totalUsers', 'activeUsers', 'inactiveUsers'));
    }

    // Method untuk pencarian
    public function search(Request $request)
    {
        $query = $request->input('search');
        
        $pendaftarans = Pendaftaran::where('nama', 'like', "%{$query}%")
            ->orWhere('nik', 'like', "%{$query}%")
            ->orWhere('no_telepon', 'like', "%{$query}%")
            ->get();

        return response()->json($pendaftarans);
    }

    // Method untuk update status
    public function updateStatus(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update([
            'status_pendaftaran' => $request->status
        ]);

        return response()->json(['success' => true, 'message' => 'Status berhasil diupdate']);
    }

    // Method untuk delete
    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();

        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
    }
}

// class DashboardController extends Controller
// {   
//     // READ - Index dengan search
//     public function index(Request $request)
//     {
//         $query = Pendaftaran::query();

//         if ($request->filled('search')) {
//             $search = $request->input('search');
//             $query->where('nama', 'like', "%{$search}%")
//                   ->orWhere('nik', 'like', "%{$search}%")
//                   ->orWhere('no_telepon', 'like', "%{$search}%");
//         }

//         $pendaftarans = $query->paginate(10);

//         $totalUsers    = Pendaftaran::count();
//         $activeUsers   = Pendaftaran::where('status_pendaftaran', 'approved')->count();
//         $inactiveUsers = Pendaftaran::where('status_pendaftaran', 'draft')->count();

//         return view('dashboard', compact('pendaftarans', 'totalUsers', 'activeUsers', 'inactiveUsers'));
//     }

//     // CREATE - Tampilkan form tambah
//     public function create()
//     {
//         return view('pendaftaran.create');
//     }

//     // STORE - Simpan data baru
//     public function store(Request $request)
//     {
//         $request->validate([
//             'nama'               => 'required|string|max:255',
//             'nik'                => 'required|string|size:16|unique:pendaftarans,nik',
//             'no_telepon'         => 'required|string|max:15',
//             'alamat'             => 'required|string',
//             'jenis_kelamin'      => 'required|in:Laki-laki,Perempuan',
//             'tanggal_lahir'      => 'required|date',
//             'tanggal_konsultasi' => 'nullable|date',
//             'waktu_konsultasi'   => 'nullable|date_format:H:i',
//             'permasalahan'       => 'nullable|string',
//             'kategori_masalah'   => 'nullable|string',
//             'dokter'             => 'nullable|string',
//             'status_pendaftaran' => 'required|in:draft,approved',
//         ]);

//         Pendaftaran::create($request->all());

//         return redirect()->route('dashboard')->with('success', 'Data pasien berhasil ditambahkan!');
//     }

//     // EDIT - Tampilkan form edit
//     public function edit($id)
//     {
//         $pendaftaran = Pendaftaran::findOrFail($id);
//         return view('pendaftaran.edit', compact('pendaftaran'));
//     }

//     // UPDATE - Simpan perubahan
//     public function update(Request $request, $id)
//     {
//         $pendaftaran = Pendaftaran::findOrFail($id);

//         $request->validate([
//             'nama'               => 'required|string|max:255',
//             'nik'                => 'required|string|size:16|unique:pendaftarans,nik,' . $id,
//             'no_telepon'         => 'required|string|max:15',
//             'alamat'             => 'required|string',
//             'jenis_kelamin'      => 'required|in:Laki-laki,Perempuan',
//             'tanggal_lahir'      => 'required|date',
//             'tanggal_konsultasi' => 'nullable|date',
//             'waktu_konsultasi'   => 'nullable|date_format:H:i',
//             'permasalahan'       => 'nullable|string',
//             'kategori_masalah'   => 'nullable|string',
//             'dokter'             => 'nullable|string',
//             'status_pendaftaran' => 'required|in:draft,approved',
//         ]);

//         $pendaftaran->update($request->all());

//         return redirect()->route('dashboard')->with('success', 'Data pasien berhasil diperbarui!');
//     }

//     // UPDATE STATUS (API - sudah ada)
//     public function updateStatus(Request $request, $id)
//     {
//         $pendaftaran = Pendaftaran::findOrFail($id);
//         $pendaftaran->update([
//             'status_pendaftaran' => $request->status
//         ]);

//         return response()->json(['success' => true, 'message' => 'Status berhasil diupdate']);
//     }

//     // DELETE - Hapus data
//     public function destroy($id)
//     {
//         $pendaftaran = Pendaftaran::findOrFail($id);
//         $pendaftaran->delete();

//         // Cek apakah request dari AJAX atau biasa
//         if (request()->expectsJson()) {
//             return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
//         }

//         return redirect()->route('dashboard')->with('success', 'Data pasien berhasil dihapus!');
//     }

//     // SEARCH API (sudah ada - tetap dipertahankan)
//     public function search(Request $request)
//     {
//         $query = $request->input('search');

//         $pendaftarans = Pendaftaran::where('nama', 'like', "%{$query}%")
//             ->orWhere('nik', 'like', "%{$query}%")
//             ->orWhere('no_telepon', 'like', "%{$query}%")
//             ->get();

//         return response()->json($pendaftarans);
//     }
// }