<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tempat;
use App\Models\User;
use App\Models\Rating;
use App\Http\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class RatingController extends Controller
{
    use Helper;

    public function index()
    {
        $rating = Rating::with([
            'user:id,name',
            'place:id,nametempat,kota'
        ])->where('isActive', true)->get();
        return $this->success($rating);
    }

    public function create()
    {
        //
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validasi = Validator::make($request->all(), [
            'userId' => 'required',
            'tempatId' => 'required',
            'comfort' => 'required',
            'cleanliness' => 'required',
            'service' => 'required',
            'location' => 'required',
            'price' => 'required',
            'review' => 'required',
        ]);
    
        if ($validasi->fails()) {
            return $this->error('Kesalahan: ' . $validasi->errors()->first());
        }

        $qtyReview = $request->qtyReview + 1;
    
        $rating = new Rating();
        $rating->userId = $request->userId;
        $rating->tempatId = $request->tempatId;
        $rating->comfort = $request->comfort;
        $rating->cleanliness = $request->cleanliness;
        $rating->service = $request->service;
        $rating->location = $request->location;
        $rating->price = $request->price;
        $rating->review = $request->review;
        $rating->qtyReview = $qtyReview;
    
        // Menghitung nilai rata-rata
        $rating1 = $request->comfort;
        $rating2 = $request->cleanliness;
        $rating3 = $request->service;
        $rating4 = $request->location;
        $rating5 = $request->price;
    
        $rating->avgRating = ($rating1 + $rating2 + $rating3 + $rating4 + $rating5) / 5;
    
        $rating->save();
    
        return $this->success($rating);
    }

    public function show($id)
    {
        $rating = Rating::where('id', $id)
            ->with([
                'user:id,name',
                'place:id,nametempat,kota'
            ])
            ->where('isActive', true)->get();
        return $this->success($rating);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $rating = Rating::where('id', $id)->first();
        if ($rating) {
            $rating->update($request->all());
            $rating1 = $request->comfort;
            $rating2 = $request->cleanliness;
            $rating3 = $request->service;
            $rating4 = $request->location;
            $rating5 = $request->price;
        
            $rating->avgRating = ($rating1 + $rating2 + $rating3 + $rating4 + $rating5) / 5;
    
            $rating->save();
            return $this->success($rating);
        } else {
            return $this->error('Belum melakukan ulasan pada tempat');
        }
    }

    public function destroy($id)
    {
        $rating = Rating::where('id', $id)->first();
        if ($rating) {
            $rating->update([
                'isActive' => false,
                'userId' => '0'
            ]);
            return $this->success($rating, "Ulasan berhasil di hapus");
        } else {
            return $this->error("Belum melakukan ulasan pada tempat");
        }
    }

    public function ulasanAll($id)
    {
        //$cari = $request->input('namaproduk');
        $data = Rating::where('tempatId', $id)
            ->where('isActive', true)->get();
        if (count($data)) {
            return $this->success($data);
        } else {
            return $this->error('Belum ada ulasan pada tempat');
        }
    }

    public function ulasan($id)
    {
        //$cari = $request->input('namaproduk');
        $data = Rating::where('tempatId', $id)
            ->where('isActive', true)
            ->get()
            ->take(3);;
        if (count($data)) {
            return $this->success($data);
        } else {
            return $this->error('Belum Ada ulasan ulasan pada tempat');
        }
    }

    public function updateJumlah(Request $request):JsonResponse
    {
        $Iduser = $request->input('userId');
        $tempatId = $request->input('tempatId');

        $update = Rating::where('userId', $Iduser)
            ->where('tempatId', $tempatId)
            ->first();

        if ($update) {
            $update->qtyReview += 1;
            $update->save();
            return $this->success($update);
        } else {
            return $this->error('Belum melakukan ulasan pada tempat');
        }
    }

    public function cekUlasan(Request $request):JsonResponse
    {
        $userId = $request->input('userId');
        $tempatId = $request->input('tempatId');

        $data = Rating::where('userId', $userId)
            ->where('tempatId', $tempatId)
            ->first();
        if($data){
            return $this->success($data, "Ayo Ubah review anda sebelumnya ya");
        }else{
            return $this->error("Ayo lakukan review terkait tempat");
        }
    }

    public function showReview($tempatId){
        $show = Rating::where('tempatId', $tempatId)
            ->sum('qtyReview');
    return $this->success($show);
    }

    public function Review($tempatId){
        $show = Rating::where('tempatId', $tempatId)
            ->get();
        return $this->success($show);
    }

    public function showReviewsMax($tempatId)
    {
        $reviews = Rating::where('tempatId', $tempatId)
            ->with([
                'user:id,name',
                'place:id,nameTempat'
            ])
            ->where('qtyReview', '>', 10)
            ->where('isActive', true)
            ->orderBy('qtyReview', 'desc')
            ->get();

        return $this->success($reviews);
    }

    public function showReviewsMin($tempatId)
    {
        $reviews = Rating::where('tempatId', $tempatId)
            ->with([
                'user:id,name',
                'place:id,nameTempat'
            ])
            ->where('qtyReview', '<', 10)
            ->where('isActive', true)
            ->orderBy('qtyReview', 'desc')
            ->get();

        return $this->success($reviews);
    }

    public function ReviewMySelf($userId){
        $show = Rating::where('userId', $userId)
            ->with([
                'place:id,nameTempat'
             ])
            ->where('isActive', true)
            ->get();
        if($show){
            return $this->success($show);
        }else{
            return $this->error("Ulasan Pengguna tidak ditemukan");
        }
    }
}

