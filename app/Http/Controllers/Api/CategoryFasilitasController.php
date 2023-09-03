<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\CategoryFasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryFasilitasController extends Controller
{
    use Helper;
    public function index(): \Illuminate\Http\JsonResponse
    {
        $categories = CategoryFasilitas::where('isActive', true)->get();
        return $this->success($categories);
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
        $categories = CategoryFasilitas::create($request->all());
        return $this->success($categories);
    }
    public function show()
    {
        $categories = CategoryFasilitas::where('isActive', true)->get();
        return $this->success($categories);
    }

    public function tampil()
    {
        $categories = CategoryFasilitas::where('isActive', true)->get();
        return $this->success($categories);
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        $categories = CategoryFasilitas::where('Id', $id)->first();
        if($categories){
            $categories->update($request->all());
            return $this->success($categories);
        } else{
            return $this->error('Category pengguna tidak ditemukan');
        }
    }
    public function destroy($id)
    {
        $categories = CategoryFasilitas::where('id', $id)->first();
        if($categories){
            $categories->update([
                'isActive' => false
            ]);
            return $this->success($categories, "Categori berhasil di hapus");
        }else{
            return $this->error("Category tidak di temukan");
        }
    }
}
