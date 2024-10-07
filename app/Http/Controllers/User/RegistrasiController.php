<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrasiController extends Controller
{
   public function index(){
    return view('users.register');
   }
   public function store(Request $request)
   {// Validasi input pengguna
$validated = $request->validate([
    'name' => 'required',
    'email' => 'required|email|unique:users',
    'password' => 'required|min:6',
    'alamat' => 'required',
    'umur' => 'required',
    'jenis_kelamin' => 'required',
]);

// Simpan data pengguna ke database
$user = User::create([
    'role_id' => 2, // Atur role_id langsung ke nilai yang diinginkan
    'name' => $validated['name'],
    'email' => $validated['email'],
    'password' => bcrypt($validated['password']),
    'alamat' => $validated['alamat'],
    'umur' => $validated['umur'],
    'jenis_kelamin' => $validated['jenis_kelamin']
]);

// Coba autentikasi pengguna setelah mendaftar
if (Auth::attempt($request->only('email', 'password'))) {
    $request->session()->regenerate();

    // Redirect ke halaman home jika berhasil
    return redirect()->intended('/home');
}

// Redirect kembali ke halaman pendaftaran jika autentikasi gagal
return redirect('/register');
   }
   
   
}
