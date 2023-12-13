<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengguna = User::all();
        return view('pengguna.index', compact('pengguna'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengguna.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'role' => 'required'
        ]);

        $password = substr($request->email, 0,3) . substr($request->name, 0,3);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => $request->role
        ]);

        return redirect()->back()->with('success', 'Berhasil Tambah Data Pengguna!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengguna = User::find($id);
        return view('pengguna.edit', compact('pengguna'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'alpha_dash',
        ]);

        $password = $request->password ? $request->password : substr($request->email, 0,3) . substr($request->name, 0,3);

        $pengguna = User::find($id);

        $pengguna->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($password)
        ]);

        // if ($password !== NULL) {
        //     $pengguna->update([
        //         'password' => Hash::make($password)
        //     ]);
        // }

        return redirect()->back()->with('success', 'Berhasil Ubah Data Pengguna!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengguna = User::find($id);

        $pengguna->delete();

        return redirect()->back()->with('success', 'Berhasil Hapus Data Pengguna!');
    }


public function loginAuth(Request $request)
{
    $request->validate([
        'email'=> 'required|email:dns',
        'password' => 'required',
    ]);

    $user=$request->only(['email', 'password']);
    if(Auth::attempt($user)){
        return redirect()->route('medicine.index');
    }else{
        return redirect()->back()->with('failed', 'proses login gagal,silahkan coba lagi kembali dengan data yang benar!');
    }
}


public function logout()

{
   Auth::logout();
   return redirect()->route('login')->with('logout', 'Anda telah logout');
}   

}

