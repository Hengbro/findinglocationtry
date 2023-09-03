<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LokasiTempat;
use App\Models\Tempat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LokasiController extends Controller
{
    public function index()
    {
        //
    }
    public function create()
    {

    }
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validasi = Validator::make($request->all(), [
            'alamat'     => 'required',
            'label'     => 'required',
            'provinsi'   => 'required',
            'kota'       => 'required',
            'kecamatan'  => 'required',
            'kodepos'    => 'required'
        ]);

        if ($validasi->fails()) {
            return $this->error('Kesalahan: ' . $validasi->errors()->first());
        }
        $lokasi = LokasiTempat::create($request->all());
        return $this->success($lokasi);
    }
    public function show($id)
    {
        $lokasi = LokasiTempat::where('tempatId', $id)->where('isActive', true)->get();
        return $this->success($lokasi);
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        $lokasi = LokasiTempat::where('Id', $id)->first();
        if($lokasi){
            $lokasi->update($request->all());
            return $this->success($lokasi);
        } else{
            return $this->error('Alamat pengguna tidak ditemukan');
        }
    }
    public function destroy($id)
    {
        $lokasi = LokasiTempat::where('id', $id)->first();
        if($lokasi){
            $lokasi->update([
                'isActive' => false
            ]);
            return $this->success($lokasi, "Alamat berhasil di hapus");
        }else{
            return $this->error("Alamat tidak di temukan");
        }
    }

    public function success($user, $message = "success"){
        return response()->json([
            'code' => 200,
            'message' => $message,
            'data' =>$user
        ]);
    }

    public function error($message){
        return response()->json([
            'code' => 400,
            'message' => $message
        ], 400);
    }
}
