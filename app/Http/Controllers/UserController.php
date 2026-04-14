<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Models\User;
use App\Models\Pendaftaran;

class UserController extends Controller
{
    public function Dashboard(){
        // Ambil data statistik
        $totalPendaftaran = Pendaftaran::count();
        $pendaftaransAktif = Pendaftaran::where('status_pendaftaran', 'draft')->count();
        $pendaftaransTidakAktif = Pendaftaran::where('status_pendaftaran', 'pending')->count();

        // Ambil semua data pendaftaran untuk tabel
        $penggunas = Pendaftaran::all(); // atau gunakan paginate(10) untuk pagination
        
        // Cek user type dan return view dengan data
        if (auth()->user()->user_type == 'admin') {
            return view('admin.dashboard', compact(
                'totalPendaftaran',
                'pendaftaransAktif', 
                'pendaftaransTidakAktif',
                'penggunas'
            ));
        }
        elseif (auth()->user()->user_type == 'user') {
            return view('profile.dashboard');
        }
    }
    //public function Dashboard(){
        //if (auth()->user()->user_type == 'admin') {
          //  return view('admin.dashboard');
        //}
        //elseif (auth()->user()->user_type == 'user') {
        //    return view('dashboard');
        //}
        //else{
           // return redirect('/');
        //}   

        // Ambil data statistik
       // $totalpendaftarans = pendaftaran::count();
       // $pendaftaransAktif = pendaftaran::where('status_pendaftaran', 'draft')->count();
        //$pendaftaransTidakAktif = pendaftaran::where('status_pendaftaran', 'panding')->count();

        // Ambil semua data pengguna untuk tabel
        //$pendaftarans = pendaftaran::all(); // atau gunakan paginate(10) untuk pagination
        
        // Kirim data ke view
        //return view('admin.dashboard', compact(
          //  'pendaftarans',
            //'pendaftaransAktif', 
            //'pendaftaransTidakAktif',
        //)); 
    //}
    
    public function index(){
        return view('homepage');
    }

    public function welcome(){
        return view('welcome');
    }

    public function form(){
        return view('pendaftaran.form');
    }
}
