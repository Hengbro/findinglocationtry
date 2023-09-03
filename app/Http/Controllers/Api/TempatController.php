<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tempat;
use App\Models\User;
use App\Http\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class TempatController extends Controller
{
    use Helper;
    public function index(): JsonResponse
    {
        $tempat = Tempat::with([
            'user:id,phone,email',
            'category:id,name',
            'address:id,alamat'
        ])->where('isActive', true)->get();
        return $this->success($tempat);
    }

    public function viewConfirmation(): JsonResponse
    {
        $tempat = Tempat::with([
            'user:id,phone,email',
            'category:id,name',
            'address:id,alamat'
        ])->where('isActive', false)->get();
        return $this->success($tempat);
    }

    public function updateConfimation(Request $request, $id): JsonResponse
    {
        $tempat = Tempat::where('id', $id)->first();
        if($tempat){
            $tempat->update($request->all());
            return $this->success($tempat);
        } else{
            return $this->error('Tempat tidak ditemukan');
        }
    }

    public function deletePlace($id): JsonResponse
    {
        $tempat = Tempat::where('id', $id)->first();
        if($tempat){
            $tempat->delete();
            return $this->success($tempat, "Tempat berhasil di hapus");
        }else{
            return $this->error("Tempat tidak di temukan");
        }
    }
    public function create()
    {
        //
    }
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validasi = Validator::make($request->all(), [
            'userId' => 'required',
            'nameTempat' => 'required',
            'kota' => 'required',
            'alamat' => 'required',
            'openH' => 'required',
            'closeH' => 'required',
            'kategoriId'=>'required',
            'kategori'=>'required',
            'status'=>'required',
            'deskription' => 'required',
        ]);

        if ($validasi->fails()) {
            return $this->error('Kesalahan: ' . $validasi->errors()->first());
        }
        $tempat = Tempat::create($request->all());
        return $this->success($tempat);
    }

    public function show($id)
    {
        $tempat = Tempat::where('userId', $id)
            ->with([
                'category:id,name',
                'address:id,alamat'
                ])
            ->where('isActive', true)->get();
        return $this->success($tempat);
    }

    public function detailTempat($id)
    {
        $tempat = Tempat::where('id', $id)
            ->with([
                'user:id,phone,email',
                'category:id,name',
                'address:id,alamat',
            ])
            ->where('isActive', true)->first();
        if($tempat){
            return $this->success($tempat);
        }
        return $this->error("Tempat tidak di temukan");
    }

    public function detailTempatConfir($id)
    {
        $tempat = Tempat::where('id', $id)
            ->with([
                'user:id,phone,email',
                'category:id,name',
                'address:id,alamat',
            ])
            ->where('isActive', false)->first();
        if($tempat){
            return $this->success($tempat);
        }
        return $this->error("Tempat tidak di temukan");
    }

    public function findRelated($cari)
    {
        //$cari = $request->input('namaproduk');
        $data = Tempat::orwhere('id','LIKE', '%'.$cari.'%')
                ->orwhere('kategori','LIKE', '%'.$cari.'%')
                ->where('isActive', true)->get()->take(8);;
        if(count($data)){
            return $this->success($data);
        }else{
            return $this->error('Data tidak di temukan');
        }
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        $tempat = Tempat::where('id', $id)->first();
        if($tempat){
            $tempat->update($request->all());
            return $this->success($tempat);
        } else{
            return $this->error('Tempat tidak ditemukan');
        }
    }
    public function destroy($id)
    {
        $tempat = Tempat::where('id', $id)->first();
        if($tempat){
            $tempat->update([
                'isActive' => false,
                'userId' => '0'
            ]);
            return $this->success($tempat, "Tempat berhasil di hapus");
        }else{
            return $this->error("Tempat tidak di temukan");
        }
    }
    public function cekTempat($id){
        $user = User::where('id', $id)->with(['tempat', 'userRole'])->first();
        if($user){
            return $this->success($user);
        }else{
            return $this->error("Pengguna tidak ditemukan");
        }
    }
    public function uploadImgTempat(Request $request){
        $fileName = "";
        if($request->imageTempat){
            $image = $request->imageTempat->getClientOriginalName();
            $image = str_replace(' ', '', $image);
            $image = date('Hs') . rand(1,999) . "_" . $image;
            $fileName = $image;
            $request->imageTempat->storeAs('public/imagetempat', $image);

            return  $this->success($fileName);
        }else{
            return $this->error("Image wajib di kirim");
        }
    }
    public function uploadImgPemilik(Request $request){
        $fileName = "";
        if($request->imagaPemilik){
            $image = $request->imagaPemilik->getClientOriginalName();
            $image = str_replace(' ', '', $image);
            $image = date('Hs') . rand(1,999) . "_" . $image;
            $fileName = $image;
            $request->imagaPemilik->storeAs('public/imagepemilik', $image);

            return  $this->success($fileName);
        }else{
            return $this->error("Image wajib di kirim");
        }
    }
    public function updateTotalByUlasan(Request $request){

        $tempatId = $request->input('tempatId');

        $tempat = Tempat::find($tempatId);
        if (!$tempat) {
            return response()->json(['message' => 'Tempat tidak ditemukan'], 404);
        }

        $totalUlasan = $tempat->ulasan()->sum('qtyReview');
        $avgUlasan = $tempat->ulasan()->avg('avgRating');
        $tempat->pengunjung = $totalUlasan;
        $tempat->avgReview = $avgUlasan;
        $tempat->save();

        return  $this->success($tempat);
    }

}
