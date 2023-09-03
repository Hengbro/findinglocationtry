<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\CartFavorite;
use App\Models\CartStore;
use App\Models\Category;
use App\Models\Rating;
use App\Models\Slider;
use App\Models\Tempat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class FavoriteController extends Controller
{
    use Helper;
    public function index(){
    }
    public function create()
    {

    }
    public function store(Request $request): JsonResponse
    {
        $validasi = Validator::make($request->all(), [
            'userId'  => 'required',
            'placeId' => 'required'
        ]);

        if ($validasi->fails()) {
            return $this->error('Kesalahan: ' . $validasi->errors()->first());
        }
        $data = CartFavorite::create($request->all());
        return $this->success($data);
    }
    public function show($Id)
    {
        $Data = CartFavorite::where('userId', $Id)
            ->with([
                'place:id,nameTempat,imageTempat,kategori,pengunjung'
            ])
            ->where('isActive', true)->get();
        return $this->success($Data);
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id): JsonResponse
    {
        $data = CartFavorite::where('Id', $id)->first();
        if($data){
            $data->update($request->all());
            return $this->success($data, "Data Berhasil Di Ubah");
        } else{
            return $this->error('Data tidak ditemukan');
        }
    }
    public function destroy($id): JsonResponse
    {
        $data = CartFavorite::where('id', $id)->first();
        if ($data) {
            $data->update([
                'isActive' => false
            ]);
            return $this->success($data, "Data berhasil di hapus");
        } else {
            return $this->error("Data tidak di temukan");
        }
    }

    public function cekFavorite(Request $request):JsonResponse
    {
        $userId = $request->input('userId');
        $placeId = $request->input('placeId');

        $data = CartFavorite::where('userId', $userId)
            ->where('placeId', $placeId)
            ->where('isActive', true)
            ->first();
        if($data){
            return $this->success($data,"Tempat favoritmu");
        }else{
            return $this->error("Ayo tambah ke favorit");
        }
    }

}
