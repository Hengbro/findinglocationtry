<?php

namespace App\Http\Middleware;

use App\Http\Helper;
use App\Models\PersonalToken;
use Closure;
use Illuminate\Http\Request;

class AuthAdmin
{
    use Helper;
    public function handle(Request $request, Closure $next){

        $token = $request->header('token');
        if(!$token){
            return $this->error("Tidak terautentikasi");
        }
        $personalToken = PersonalToken::where('token', $token)->first();
        if($personalToken){
            $user = $personalToken->user;
            try{
                if($user->userRole->isAdmin){
                    return $next($request);
                } else{
                    return $this->error("Akses ditolak: Hanya admin yang dapat mengakses");
                }
            } catch(\Exception $e) {
                return $this->error("Pengguna tidak ditemukan");
            }
        } else {
            return $this->error("Token Expired");
        }
    }
}
