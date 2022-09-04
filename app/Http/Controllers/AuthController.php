<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('index');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'bail|required',
            'password' => 'bail|required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->user()->update(['api' => Str::uuid()]);

            $request->session()->regenerate();

            if ($request->user()->role == 'admin') {
                return redirect('app/employee');
            }

            return redirect('app/barang');
        }

        return redirect()->back()->withErrors("Login gagal, cek kembali email dan password anda");
    }

    public function unauthenticate(Request $request)
    {
        $request->user()->update(['api' => null]);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
