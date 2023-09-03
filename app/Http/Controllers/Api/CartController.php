<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\CartProduct;
use App\Models\CartStore;
use App\Models\Category;
use App\Models\PersonalToken;
use App\Models\ProdukTemp;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class CartController extends Controller
{
    use Helper;
    public function index(Request $request): JsonResponse{
        $userId = $this->getUserId($request);
        $Data = CartStore::where('userId', $userId)
            ->with('items')
            ->get();
        return $this->success($Data);
    }
    public function create()
    {

    }
    public function store(Request $request): JsonResponse{

        $validasi = Validator::make($request->all(), [
            'productId'=> 'required'
        ]);

        if ($validasi->fails()) {
            return $this->error('Kesalahan: ' . $validasi->errors()->first());
        }

        $userId = $this->getUserId($request);
        $product = ProdukTemp::find($request->productId);
        $cartStore = CartStore::where('userId', $userId)
        ->where('storeId', $product->tempatId)
        ->first();

        if($cartStore){
            $cartStore->update([
                'lastInsert' => now()
            ]);
        } else {
            $cartStore = CartStore::create([
                'userId' => $userId,
                'storeId' => $product->tempatId,
                'lastInsert' => now()
            ]);
        }

        $cartProduct = CartProduct::where('productId', $product->id)
            ->where('storeId', $cartStore->id)
            ->first();
        if($cartProduct){
            $cartProduct->update([
                'qty' => $cartProduct->qty + 1
            ]);
        } else {
            $cartProduct = CartProduct::create([
                'userId' => $userId,
                'storeId' => $cartStore->id,
                'productId' => $product->id,
            ]);
        }
        $cartStore->$product = $cartProduct;
        return $this->success($cartStore);
    }
    public function show()
    {

    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {

    }

    public function updateCartStore(Request $request): JsonResponse{

        $data = CartStore::find($request->id);
        if($data){
            $data->update($request->all());
            return $this->success($data);
        } else{
            return $this->error('Tempat pengguna tidak ditemukan');
        }
    }

    public function updateCartProduct(Request $request): JsonResponse{

        $data = CartProduct::find($request->id);
        if($data){
            $data->update($request->all());
            return $this->success($data);
        } else{
            return $this->error('Produk pengguna tidak ditemukan');
        }
    }
    public function destroy($id): JsonResponse
    {
        $data = CartProduct::find($id);
        if($data){
            $countItem = CartProduct::where('storeId', $data->storeId)->count();
            if($countItem == 1){
                $cartStore = CartStore::find($data->storeId);
                $cartStore->delete();
            }
            $data->delete();
            return $this->success($data, "Produk berhasil di hapus");
        }else{
            return $this->error("Produk tidak di temukan");
        }
    }
}
