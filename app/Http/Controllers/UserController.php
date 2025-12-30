<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function Dashboard(){
        if (auth()->user()->user_type == 'admin') {
            return view('admin.dashboard');
        }
        elseif (auth()->user()->user_type == 'user') {
            return view('dashboard');
        }
        else{
            return redirect('/');
        }     
    }
    
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
