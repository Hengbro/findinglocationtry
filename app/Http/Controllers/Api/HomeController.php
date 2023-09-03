<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\category;
use App\Models\Slider;
use App\Models\Tempat;
use Carbon\Carbon;

class HomeController extends Controller
{
    use Helper;

    public function newPlace()
    {
        //$end = Carbon::parse($request->strtime("-30 days"));
        $data = Tempat::where('created_at', '>=', Carbon::now()->subMonth(1))//[$start, $end]
         ->with([
            'category:id,name',
            'address:id,alamat',
        ])
        ->where('isActive', true)
            ->orderBy('pengunjung', 'desc')
            ->get()
            ->take(8);
        //$produk = Produk::whereBetween('created_at',[1, 30])->where('isActive', true)->get();
        return $this->success($data);
    }

    public function newPlaceAll()
    {
        //$end = Carbon::parse($request->strtime("-30 days"));
        $data = Tempat::where('created_at', '>=', Carbon::now()->subMonth(1))//[$start, $end]
        ->with([
            'category:id,name',
            'address:id,alamat',
        ])
            ->where('isActive', true)
            ->orderBy('pengunjung', 'desc')
            ->get();
        //$produk = Produk::whereBetween('created_at',[1, 30])->where('isActive', true)->get();
        return $this->success($data);
    }

    public function getHome(){
        $place = Tempat::with([
            'category:id,name',
            'address:id,alamat',
        ])
            ->where('isActive', true)
            ->orderBy('pengunjung', 'desc')
            ->get();
        return $this->success($place);
    }
    public function getHomeCategory(){
        $categories = category::where('isActive', true)->get();
        return $this->success($categories);
    }

    public function getHomeSlider(){
        $slider = Slider::where('isActive', true)->get();
        return $this->success($slider);
    }
    public function finding($cari)
    {
        //$cari = $request->input('namaproduk');
        $data = Tempat::orwhere('id','LIKE', '%'.$cari.'%')
            ->orwhere('kota','LIKE', '%'.$cari.'%')
            ->orwhere('nametempat','LIKE', '%'.$cari.'%')
            ->orwhere('deskription','LIKE', '%'.$cari.'%')
            ->orwhere('openH','LIKE', '%'.$cari.'%')
            ->orwhere('closeH','LIKE', '%'.$cari.'%')
            ->orwhere('kategoriId','LIKE', '%'.$cari.'%')
            ->orwhere('kategori','LIKE', '%'.$cari.'%')
            ->where('isActive', true)
            ->orderBy('pengunjung', 'desc')
            ->get();
        if(count($data)){
            return $this->success($data);
        }else{
            return $this->error('Data tidak di temukan');
        }
    }
}
