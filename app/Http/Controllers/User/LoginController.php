<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('users.login');
    }

    public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required']
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user(); // Get the authenticated user

        if ($user->email === 'admin@gmail.com') {
            return redirect('/'); // Redirect to root path for admin
        } elseif ($user->email === 'ekspedisi@gmail.com') {
            return redirect('/ekspedisi-pesanan'); // Redirect to root path for owner (you can change this to a specific owner dashboard route)
        } else {
            return redirect()->intended('/home'); // Default redirect for other users
        }
    }

    Session::flash('status', 'error');
    Session::flash('message', 'Email atau password anda salah');

    return redirect('/login');
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/home');
    }

   
}
