<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign default role 'User'
        $userRole = \App\Models\Role::where('name', 'User')->first();
        if ($userRole) {
            $user->roles()->attach($userRole->id);
        }

        return redirect('/login')->with('success', 'Berhasil daftar!');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Cek apakah user adalah admin
            if ($user->isAdmin()) {
                return redirect('/admin/dashboard');
            }
            // Cek apakah user adalah petugas
            if ($user->isPetugas()) {
                return redirect('/petugas/dashboard');
            }
            
            // Jika bukan admin atau petugas, arahkan ke dasbor pelanggan
            return redirect('/dashboard');
        }

        return back()->with('error', 'Email atau password salah');
    }
}
