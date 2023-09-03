<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\CartProduct;
use App\Models\CartStore;
use App\Models\Fasilitas;
use App\Models\KeranjangProduct;
use App\Models\KeranjangTempat;
use App\Models\ProdukTemp;
use App\Models\Rating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartPlaceController extends Controller
{
    use Helper;
    public function index()
    {
        //
    }

    public function viewUserId($userId): JsonResponse
    {
        $data = KeranjangTempat::with([
            'place:id,nameTempat',
            'user:id,name',
        ])
            ->where('userId',$userId)
            ->where('isActive',true)
            ->get();
        return $this->success($data);
    }

    public function viewTempatId($tempatId): JsonResponse
    {
        $data = KeranjangTempat::with([
            'place:id,nameTempat',
            'user:id,name',
        ])
            ->where('tempatId',$tempatId)
            ->where('isActive',true)
            ->get();
        return $this->success($data);
    }

    public function viewHistoryOrder($userId): JsonResponse
    {
        $data = KeranjangTempat::with([
            'place:id,nameTempat',
            'user:id,name',
        ])
            ->where('userId',$userId)
            ->where('isActive',false)
            ->get();
        return $this->success($data);
    }

    public function viewisActiveOff($tempatId): JsonResponse
    {
        $data = KeranjangTempat::with([
            'place:id,nameTempat',
            'user:id,name',
        ])
            ->where('tempatId',$tempatId)
            ->where('isActive',false)
            ->get();
        return $this->success($data);
    }

    public function konfirmation($id, Request $request): JsonResponse
    {
        $tempat = KeranjangTempat::where('id', $id)->where('isActive', true)->first();
        $product = KeranjangProduct::where('id', $id)->where('isOrder', true);
        if (!$tempat) {
            return response()->json(['error' => 'Pesanan-mu tidak ditemukan'], 404);
        }
        $tempat->isActive = false;
        $tempat->status = $request->input('status', 'Sudah Bayar');
        $tempat->save();
        return response()->json(['data' => $tempat], 200);
    }


    public function create()
    {
        //
    }
    public function store(Request $request): JsonResponse
    {
        $validasi = Validator::make($request->all(), [
            'userId' => 'required',
            'tempatId' => 'required'
        ]);

        if ($validasi->fails()) {
            return $this->error('Kesalahan: ' . $validasi->errors()->first());
        }
        $userId = $request->input('userId');
        $tempatId = $request->input('tempatId');
        $totalQty = KeranjangProduct::where('userId', $userId)->where('isOrder', true)->sum('qty');
        $totalPrice = KeranjangProduct::where('userId', $userId)->where('isOrder', true)->sum('tot_harga');

        $keranjang = KeranjangTempat::where('userId', $userId)
            ->where('tempatId', $tempatId)
            ->where('isActive', true)
            ->first();

        if ($keranjang) {
            $keranjang->sum_qty = $totalQty;
            $keranjang->sum_harga = $totalPrice;
            $keranjang->save();
            return $this->success($keranjang);

        } else {

            $rating = new KeranjangTempat();
            $rating->userId = $userId;
            $rating->tempatId = $tempatId;
            $rating->status = "Belum Bayar";
            $rating->sum_qty = $totalQty;
            $rating->sum_harga = $totalPrice;
            $rating->lastInsert = now();
            $rating->save();
            return $this->success($rating);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
