<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestingController extends Controller
{
    public function changePassword()
    {
        return view('content.user.change-password');
    }

    public function updatePassword(Request $request)
    {
        $validate = $request->validate([
            'old_password' => 'required',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required_with:password|same:password|min:6',
        ]);
        #cek dulu apakah password lama benar
        if (password_verify($request->old_password, Auth::user()->password)) {
            $user = Auth::user();
            $user->password = password_hash($request->password, PASSWORD_DEFAULT);
            $user->save();
            return back()->with('berhasil', 'Pasword Berhasil diubah');
        }
        return back()->with('gagal', 'Gagal Mengubah Password, Password yang Anda Masukan Salah');
    }
 
}
