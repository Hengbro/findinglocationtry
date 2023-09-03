<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper;
use App\Models\HistorySearch;
use Illuminate\Support\Facades\Validator;

class HistorySearchController extends Controller
{
    use Helper;
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validasi = Validator::make($request->all(), [
            'userId' =>'required',
            'name'=> 'required',
        ]);

        if ($validasi->fails()) {
            return $this->error('Kesalahan: ' . $validasi->errors()->first());
        }
        $product = HistorySearch::create($request->all());
        return $this->success($product);
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

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $search = HistorySearch::where('id', $id)->first();
        if($search){
            $search->update([
                'isActive' => false
            ]);
            return $this->success($search, "Pencarian berhasil di hapus");
        }else{
            return $this->error("Pencarian tidak di temukan");
        }
    }

    public function showByUserId($userId): \Illuminate\Http\JsonResponse
    {
        $show = HistorySearch::where('userId', $userId)
                ->where('isActive', true)
                ->get();
        return $this->success($show);
    }
}
