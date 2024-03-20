<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('content.auth.login');
    }

    public function verify(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        #kondisi dimana data tidak ada yang kosong
        $pesanError = 'Kombinasi Email dan Password Tidak ditemukan';
        $user = User::query()->where('email', $request->email)->first();
        if ($user !== null) {
            if (password_verify($request->password, $user->password)) {
                #kondisi dimana passwordnya terverifikasi
                Auth::login($user);
                $request->session()->regenerate();
                return redirect('/teacher');
            }
        }
        return redirect()->back()->with('gagal', $pesanError);
    }
}

