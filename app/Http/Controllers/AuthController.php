<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;




class AuthController extends Controller
{
    public function index() {
        if (auth()->check()) {
            return redirect()->route('medicine.index');
        }
        return view('login');
    }

    public function login(Request $request) {
    $request->validate([
        'email' => 'required',
        'password' => 'required'
    ], [
        'email.required' => 'Email tidak boleh kosong',
        'password.required' => 'Password tidak boleh kosong'
    ]);

    $credentials = $request->only('email', 'password');
    if (auth()->attempt($credentials)) {
        return redirect()->route('medicine.index')->with('messageLogin', 'Login Sukses!');
    }

    return redirect()->route('login')->with('loginError', 'Identitas tidak valid');
    }

    public function signOut() {
        Session::flush();
        auth()->logout();
        return redirect()->route('login');
    }

}

