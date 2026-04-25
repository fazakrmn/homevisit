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