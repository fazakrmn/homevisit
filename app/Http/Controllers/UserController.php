<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pendaftaran;

class UserController extends Controller
{
    public function Dashboard()
    {
        // Ambil data statistik
        $totalPendaftaran = Pendaftaran::count();
        $pendaftaransAktif = Pendaftaran::where('status_pendaftaran', 'draft')->count();
        $pendaftaransTidakAktif = Pendaftaran::where('status_pendaftaran', 'pending')->count();

        // Ambil semua data pendaftaran untuk tabel
        $penggunas = Pendaftaran::all();

        // Cek user type dan return view dengan data
        if (auth()->user()->user_type == 'admin') {
            return view('admin.dashboard', compact(
                'totalPendaftaran',
                'pendaftaransAktif',
                'pendaftaransTidakAktif',
                'penggunas'
            ));
        } elseif (auth()->user()->user_type == 'user') {
            return view('profile.dashboard');
        }
    }

    public function index()
    {
        return view('homepage');
    }

    public function welcome()
    {
        return view('welcome');
    }
}
