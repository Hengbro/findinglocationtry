<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    use Helper;
    public function index(): \Illuminate\Http\JsonResponse
    {
        $Slider = Slider::where('isActive', true)->get();
        return $this->success($Slider);
    }
    public function create()
    {

    }
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validasi = Validator::make($request->all(), [
            'name'     => 'required',
            'description'=> 'required'
        ]);

        if ($validasi->fails()) {
            return $this->error('Kesalahan: ' . $validasi->errors()->first());
        }
        $slider = Slider::create($request->all());
        return $this->success($slider);
    }
    public function show(): \Illuminate\Http\JsonResponse
    {
        $slider = Slider::where('isActive', true)->get();
        return $this->success($slider);
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $slider = Slider::where('Id', $id)->first();
        if($slider){
            $slider->update($request->all());
            return $this->success($slider);
        } else{
            return $this->error('Slider pengguna tidak ditemukan');
        }
    }
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $slider = Slider::where('id', $id)->first();
        if($slider){
            $slider->delete();
            return $this->success($slider, "Slider berhasil di hapus");
        }else{
            return $this->error("Slider tidak di temukan");
        }
    }
}
