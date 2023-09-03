<?php

namespace App\Http;
use App\Models\PersonalToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait Helper{

    public function getUserId(Request $request){
        $token = PersonalToken::where('token', $request->header('token'))->first();
        return $token->userId;
    }
    public function success($user, $message = "success") : JsonResponse {
        return response()->json([
            'code' => 200,
            'message' => $message,
            'data' =>$user
        ]);
    }

    public function error($message): JsonResponse {
        return response()->json([
            'code' => 400,
            'message' => $message
        ], 400);
    }

    public function generateToken(): string{
        $alfabet = "abcdefghijklmnopqrstuvwxyz";
        $alfabetUpecase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $numerik = "1234567890";
        //$char = "!@#$%^&*()<>?/{}[]";
        $allCart = $alfabet . $alfabetUpecase . $numerik;
        return substr(str_shuffle($allCart), 0, 30);
    }
}
