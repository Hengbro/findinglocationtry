<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\CartProduct;
use App\Models\CartStore;
use App\Models\Category;
use App\Models\KeranjangTempat;
use App\Models\KeranjangProduct;
use App\Models\ProdukTemp;
use App\Models\Tempat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartProductController extends Controller
{
    use Helper;
    public function index(): JsonResponse
    {
        $data = KeranjangProduct::with([
            'user:id,name',
            'place:id,nameTempat',
            'product:id,name,price'
        ])->where('isActive', true)->get();
        return $this->success($data);
    }

    public function viewByUserID($userId): JsonResponse
    {
        $data = KeranjangProduct::with([
            'user:id,name',
            'place:id,nameTempat',
            'product:id,name,price'
        ])
            ->where('userId', $userId)
            ->where('isActive', true)
            ->get();
        return $this->success($data);
    }

    public function viewByOrder($userId): JsonResponse
    {
        $data = KeranjangProduct::with([
            'user:id,name',
            'place:id,nameTempat',
            'product:id,name,price'
        ])
            ->where('userId', $userId)
            ->where('isOrder', true)
            ->get();
        return $this->success($data);
    }

    public function viewOrderByPlace($placeId): JsonResponse
    {
        $data = KeranjangProduct::with([
            'user:id,name',
            'place:id,nameTempat',
            'product:id,name,price'
        ])
            ->where('tempatId', $placeId)
            ->where('isOrder', true)
            ->get();
        return $this->success($data);
    }

    public function create()
    {
        //
    }
    public function store(Request $request): JsonResponse
    {
        $validasi = Validator::make($request->all(), [
            'userId' => 'required',
            'tempatId' => 'required',
            'productId' => 'required'
        ]);

        if ($validasi->fails()) {
            return $this->error('Kesalahan: ' . $validasi->errors()->first());
        }

        $userId = $request->input('userId');
        $tempatId = $request->input('tempatId');
        $productId = $request->input('productId');
        $harga = ProdukTemp::find($productId);

        $keranjang = KeranjangProduct::where('userId', $userId)
            ->where('tempatId', $tempatId)
            ->where('productId', $productId)
            ->where('isActive', true)
            ->first();

        if ($keranjang) {
            $keranjang->qty += 1;
            $keranjang->tot_harga = $keranjang->qty * $harga->price;
            $keranjang->save();

            return $this->success($keranjang);
        } else {
            $harga = ProdukTemp::find($productId);

            if (!$harga) {
                return $this->error('Produk tidak ditemukan.');
            }

            $qtyReview = $request->input('qtyReview') + 1;

            $rating = new KeranjangProduct();
            $rating->userId = $userId;
            $rating->tempatId = $tempatId;
            $rating->productId = $productId;
            $rating->qty = $qtyReview;
            $rating->tot_harga = $harga->price * $qtyReview;
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
        
    }

    public function Order($userId): JsonResponse
    {
        $tempat = KeranjangProduct::where('userId',$userId)
            ->where('isActive',true);

        if($tempat){
            $tempat->update(['isActive' => false,
                'isOrder'=> true ]);
            return $this->success($tempat, "Tunggu pesanan-mu datang ya");
        } else{
            return $this->error('Pesanan mu tidak ditemukan');
        }
    }

    public function finishKonfir($userId): JsonResponse
    {
        $product = KeranjangProduct::where('userId', $userId)->where('isOrder', true);

        if($product){
            $product->update(['isOrder'=> false]);
            return $this->success($product, "Pesanan mu berhasil di bayar");
        } else{
            return $this->error('Pesanan mu tidak ditemukan');
        }
    }

    public function destroy($id)
    {
        $hapus = CartProduct::where('id', $id);
        if($hapus){
            $hapus->delete();
            return $this->success($hapus, "Produk berhasil di hapus");
        } else{
            return $this->error('Produk tidak ditemukan');
        }
    }

    public function viewHistoryProductUser($cartPlace): JsonResponse
    {
        $data = KeranjangProduct::with([
            'user:id,name',
            'place:id,nameTempat',
            'product:id,name,price'
        ])
            ->where('cartPlaceId', $cartPlace)
            ->where('isActive', false)
            ->get();
        return $this->success($data);
    }

    public function addIdCartPlace(Request $request){
        $userId = $request->input('userId');
        $tempatId = $request->input('tempatId');
    
        $cart = KeranjangTempat::where('userId', $userId)
                    ->where('isActive', true)
                    ->where('status', 'Belum Bayar')
                    ->first();
    
        if ($cart) {
            $updatedCount = KeranjangProduct::where('userId', $userId)
                            ->where('tempatId', $tempatId)
                            ->where('isOrder', true)
                            ->update(['cartPlaceId' => $cart->id]);
    
            if ($updatedCount > 0) {
                return $this->success($updatedCount,"CartPlaceId berhasil diupdate untuk produk yang sesuai.");
            } else {
                return $this->error('Tidak ada data produk yang sesuai ditemukan.');
            }
        } else {
            return $this->error('Keranjang tempat tidak ditemukan atau belum dibayar.');
        }
    }
}


