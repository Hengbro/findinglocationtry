<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FasilitasController extends Controller
{
    use Helper;
    public function index()
    {
        $data = Fasilitas::where('isActive', true)->get();
        return $this->success($data);
    }

    public function create()
    {

    }
    
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validasi = Validator::make($request->all(), [
            'tempatId' =>'required',
            'name'=> 'required',
            'stock'=> 'required',
            'category'=>'required',
            'description'=> 'required',
        ]);

        if ($validasi->fails()) {
            return $this->error('Kesalahan: ' . $validasi->errors()->first());
        }
        $fasilitas = Fasilitas::create($request->all());
        return $this->success($fasilitas);
    }
    public function show($id)
    {
        $fasilitas = Fasilitas::where('tempatId', $id)->where('isActive', true)->get();
        return $this->success($fasilitas);
    }

    public function menufasilitas($id)
    {
        $data = Fasilitas::where('tempatId',$id)  
            ->where('isActive', true)
            ->get()
            ->take(4);
        return $this->success($data);
    }

    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        $fasilitas = Fasilitas::where('id', $id)->first();
        if($fasilitas){
            $fasilitas->update($request->all());
            return $this->success($fasilitas);
        } else{
            return $this->error('Fasilitas tidak ditemukan');
        }
    }

    public function getPlace($categoryId){
    $fasilitas = Fasilitas::where('categoryId', $categoryId)
         ->with('place')
         ->get();
         return $this->success($fasilitas);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $fasilitas = Fasilitas::where('id', $id)->first();
        if($fasilitas){
            $fasilitas->update([
                'isActive' => false
            ]);
            return $this->success($fasilitas, "Fasilitas berhasil di hapus");
        }else{
            return $this->error("Fasilitas tidak di temukan");
        }
    }

    public function upload(Request $request){
        $fileName = "";
        if($request->image){
            $image = $request->image->getClientOriginalName();
            $image = str_replace(' ', '', $image);
            $image = date('Hs') . rand(1,999) . "_" . $image;
            $fileName = $image;
            $request->image->storeAs('public/menufasilitas', $image);

            return  $this->success($fileName);
        }else{
            return $this->error("Image wajib di kirim");
        }
    }

}
