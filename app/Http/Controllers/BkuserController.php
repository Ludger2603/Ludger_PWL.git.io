<?php

namespace App\Http\Controllers;

use App\Models\bkuser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BkuserController extends Controller
{
    public function list()
    {
        $bkuser = bkuser::query()
            ->paginate();
        return view('content.pesan.list', [
            'bkuser' => $bkuser
        ]);
    }
    public function pesanan()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $bkuser = Bkuser::where('id_user', $user->id)
            ->paginate();

        return view('content.pesan.keranjang', [
            'bkuser' => $bkuser,
            'user' => $user
        ]);
    }

    public function add(){
        return view('content.pesan.add');
    }
    public function insert(Request $request){
        try {
        $validated = $request->validate([
            'id_user' => 'required',
            'name' => 'required',
            'no_plat' => 'required',
            'name_motor' => 'required',
            'lama_sewa' => 'required',
            'keterangan' => 'required'
        ]);
        #sudah tervalidasi
        $bkuser = new bkuser();
        $bkuser->id_user = $request->id_user;
        $bkuser->name = $request->name;
        $bkuser->no_plat = $request->no_plat;
        $bkuser->name_motor = $request->name_motor;
        $bkuser->lama_sewa = $request->lama_sewa;
        $bkuser->keterangan = $request->keterangan;
        $bkuser->save();
        Session::flash('success', 'Pesanan Anda Berhasil Silahkan Tunggu Verifikasi.');
    
            return redirect(url('/dashboard'));

        } catch (ModelNotFoundException $e) {
            Session::flash('error', 'Gagal memesan. Pesanan Gagal.');
            return redirect(url('/dashboard'));
        } catch (\Exception $e) {
            Session::flash('error', 'Terjadi kesalahan. Gagal Menambah Pesanan.');
            return redirect(url('/dashboard'));
        }
    }
    public function edit(Request $request, $id)
    {
        $bkuser = bkuser::find($id);
        if ($bkuser === null) {
            abort(404);
        }
        return view('content.pesan.edit', [
            'bkuser' => $bkuser
        ]);
    }
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'no_plat' => 'required',
                'name_motor' => 'required',
                'lama_sewa' => 'required',
                'keterangan' => 'required'
            ]);
    
            $bkuser = bkuser::findOrFail($request->id);
    
            $bkuser->name = $request->name;
            $bkuser->no_plat = $request->no_plat;
            $bkuser->name_motor = $request->name_motor;
            $bkuser->lama_sewa = $request->lama_sewa;
            $bkuser->keterangan = $request->keterangan;
            $bkuser->save();
    
            // Tambahkan pesan keberhasilan ke sesi
            Session::flash('success', 'Data pesanan berhasil diperbarui.');
    
            return redirect(url('/pesanan'));

        } catch (ModelNotFoundException $e) {
            Session::flash('error', 'Gagal memperbarui data motor. Motor tidak ditemukan.');
            return redirect(url('/pesanan'));
        } catch (\Exception $e) {
            Session::flash('error', 'Terjadi kesalahan. Gagal memperbarui data motor.');
            return redirect(url('/pesanan'));
        }
    }
    public function batal(Request $request)
    {
        try {
            $validated = $request->validate([
                'pembatalan' => 'required|in:Dipesan,Dibatalkan',
            ]);
    
            $bkuser = bkuser::findOrFail($request->id);
    
            $bkuser->pembatalan = $request->pembatalan;
            $bkuser->save();
    
            // Tentukan pesan berdasarkan nilai pembatalan
            if ($request->pembatalan == 'Dibatalkan') {
                Session::flash('success', 'Data pesanan berhasil dibatalkan.');
            } else {
                Session::flash('success', 'Data pesanan berhasil dilanjutkan.');
            }
    
            return redirect(url('/pesanan/keranjang'));
    
        } catch (ModelNotFoundException $e) {
            Session::flash('error', 'Gagal memperbarui data pesanan. Pesanan tidak ditemukan.');
            return redirect(url('/pesanan/keranjang'));
        } catch (\Exception $e) {
            Session::flash('error', 'Terjadi kesalahan. Gagal memperbarui data pesanan.');
            return redirect(url('/pesanan/keranjang'));
        }
    }
    public function delete(Request $request)
    {
        $idPesan = $request->id;
        $bkuser = bkuser::find($idPesan);
        if ($bkuser === null) {
            return response()->json([], 404);
        }
        $bkuser->delete();
        return response()->json([], 200);
    }
}
