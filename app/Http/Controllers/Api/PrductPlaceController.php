<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\ProdukTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrductPlaceController extends Controller
{
    use Helper;
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
            'tempatId' =>'required',
            'name'=> 'required',
            'price'=> 'required',
            'category'=>'required',
            'description'=> 'required',
        ]);

        if ($validasi->fails()) {
            return $this->error('Kesalahan: ' . $validasi->errors()->first());
        }
        $product = ProdukTemp::create($request->all());
        return $this->success($product);
    }
    public function show($id)
    {
        $product = ProdukTemp::where('tempatId', $id)->where('isActive', true)->get();
        return $this->success($product);
    }

    public function menuproduct($id)
    {
        $data = ProdukTemp::where('tempatId',$id)  
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
        $product = ProdukTemp::where('id', $id)->first();
        if($product){
            $product->update($request->all());
            return $this->success($product);
        } else{
            return $this->error('Produk tidak ditemukan');
        }
    }
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $product = ProdukTemp::where('id', $id)->first();
        if($product){
            $product->update([
                'isActive' => false
            ]);
            return $this->success($product, "Produk berhasil di hapus");
        }else{
            return $this->error("Produk tidak di temukan");
        }
    }

    public function upload(Request $request){
        $fileName = "";
        if($request->image){
            $image = $request->image->getClientOriginalName();
            $image = str_replace(' ', '', $image);
            $image = date('Hs') . rand(1,999) . "_" . $image;
            $fileName = $image;
            $request->image->storeAs('public/menuproduct', $image);

            return  $this->success($fileName);
        }else{
            return $this->error("Image wajib di kirim");
        }
    }

}
