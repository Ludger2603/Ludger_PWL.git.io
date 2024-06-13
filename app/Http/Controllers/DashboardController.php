<?php

namespace App\Http\Controllers;

use App\Models\bkuser;
use App\Models\Motor;
use App\Models\SyaratS;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $user = User::count();
        $userT = Auth::user();
        $pesanan = bkuser::where('pembatalan', 'Dipesan')->count();
        $syarat = SyaratS::first();
        $motor = Motor::count();
        $kendaraan = Motor::latest()->get()->take(6);
        return view('content.dashboard', [
            'kendaraan' => $kendaraan,
            'user' => $user,
            'userT' => $userT,
            'motor' => $motor,
            'syarat' => $syarat,
            'pesanan' => $pesanan
        ]);
    }
}
