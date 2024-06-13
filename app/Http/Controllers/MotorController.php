<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class MotorController extends Controller
{
    public function list()
    {
        $motors = Motor::query()
            ->paginate();
        return view('content.motor.list', [
            'motors' => $motors
        ]);
    }

    public function add(){
        return view('content.motor.add');
    }
    public function insert(Request $request){
        $validated = $request->validate([
            'gambar' => 'image|required',
            'name' => 'required',
            'no_plat' => 'required',
            'type' => 'required',
            'year' => 'required',
            'price_per_day' => 'required',
            'denda' => 'required',
            'availability' => 'required'
        ]);
        #sudah tervalidasi
        $motor = new Motor();
        $gambarPath = $request->file('gambar')->store('public/images');
        $namaGambar = $request->file( 'gambar' )->hashName();
    
        $motor->gambar = $namaGambar;
        $motor->name = $request->name;
        $motor->no_plat = $request->no_plat;
        $motor->type = $request->type;
        $motor->year = $request->year;
        $motor->denda = $request->denda;
        $motor->availability = $request->availability;
        $motor->price_per_day = $request->price_per_day;
        $motor->save();
        return redirect(url('/motor'));
    }
    public function edit(Request $request, $id)
    {
        $motors = Motor::find($id);
        if ($motors === null) {
            abort(404);
        }
        return view('content.motor.edit', [
            'motors' => $motors
        ]);
    }
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'no_plat' => 'required',
                'type' => 'required',
                'year' => 'required',
                'price_per_day' => 'required',
                'denda' => 'required',
                'availability' => 'required'
            ]);
    
            $motor = Motor::findOrFail($request->id);

            if ($request->hasFile('gambar')) {
                $oldImagePath = storage_path('app/public/images/' . $motor->gambar);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
    
            $motor->name = $request->name;
            $motor->no_plat = $request->no_plat;
            $motor->type = $request->type;
            $motor->year = $request->year;
            $motor->denda = $request->denda;
            $motor->availability = $request->availability;
            $motor->price_per_day = $request->price_per_day;
            if($request->hasFile('gambar')) {
                $gambarPath = $request->file('gambar')->store('public/images');
                $gambarName = $request->file('gambar')->hashName(); 
                $motor->gambar = $gambarName; // Simpan nama file gambar saja
            }
            $motor->save();
    
            // Tambahkan pesan keberhasilan ke sesi
            Session::flash('success', 'Data motor berhasil diperbarui.');
    
            return redirect(url('/motor'));
    
        } catch (ModelNotFoundException $e) {
            Session::flash('error', 'Gagal memperbarui data motor. Motor tidak ditemukan.');
            return redirect(url('/motor'));
        } catch (\Exception $e) {
            Session::flash('error', 'Terjadi kesalahan. Gagal memperbarui data motor.');
            return redirect(url('/motor'));
        }
    }
    public function delete(Request $request)
    {
        $idMotor = $request->id;
        $motor = Motor::find($idMotor);
        if ($motor === null) {
            return response()->json([], 404);
        }
        $motor->delete();
        return response()->json([], 200);
    }
}
