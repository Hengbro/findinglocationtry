<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\Review;
use App\Models\User;
use App\Models\Tempat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    use Helper;
    public function updateJumlah(Request $request){

        $userId = $request->input('userId');
        $tempatId = $request->input('tempatId');

        $update = Review::where('userId', $userId)
            ->where('tempatId', $tempatId)
            ->first();

        if ($update) {
            $update->qtyReview += 1;
            $update->save();

        } else {
        // Buat entri baru jika tidak ada data dengan userId dan tempatId yang diberikan
           $add = Review::create([
                'userId' => $userId,
                'tempatId' => $tempatId,
                'qtyReview' => 1
        ]);
        }
        return $this->success($update);
    }

    public function showReview($tempatId){
        $show = Review::where('tempatId', $tempatId)
                ->sum('qtyReview');
        return $this->success($show);
    }

    public function Review($tempatId){
        $show = Review::where('tempatId', $tempatId)
            ->get();
        return $this->success($show);
    }

}
