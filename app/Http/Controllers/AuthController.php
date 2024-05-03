<?php

namespace App\Http\Controllers;

use App\Mail\RegisterMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        $user = User::query()
            ->where('email', $request->email)
            ->where('is_active', 1)
            ->first();
        if ($user !== null) {
            if (password_verify($request->password, $user->password)) {
                #kondisi dimana passwordnya terverifikasi
                Auth::login($user);
                $request->session()->regenerate();
                return redirect('/dashboard');
            }
        }
        return redirect()->back()->with('gagal', $pesanError);
    }

    public function register()
    {
        return view('content.register.index');
    }

    public function registerProceed(Request $request)
    {
        #tugas buat validasi
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        #kondisi semua data ada
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $user = User::query()->where('email', $email)->first();
        if ($user !== null) {
            #email sudah digunakan, tidak boleh mendaftar lagi
            return back()->with('gagal', 'Tidak dapat mendaftar menggunakan email yang sama.');
        }
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->is_active = 0;
        $user->token_activation = md5($email . date('Y-m-dH:i:s'));
        $user->save();
        #kirim email.
        Mail::to($user->email)->queue(new RegisterMail($user));
        return redirect('/login')->with('sukses', 'Registrasi Berhasil, cek email anda untuk aktivasi');
    }

    public function registerVerify($token)
    {
        #get user by token
        $user = User::query()->where('token_activation', $token)->first();
        if ($user === null) {
            return redirect('/login')->with('gagal', 'Token tidak ditemukan');
        }
        #user ada
        $user->token_activation = null;
        $user->is_active = 1;
        $user->save();
        return redirect('/login')->with('sukses', 'Aktivasi Berhasil, anda sudah bisa login');
    }
}

