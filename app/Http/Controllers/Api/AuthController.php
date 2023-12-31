<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\PersonalToken;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use Helper;
    public function login(Request $request)
    {

        $validasi = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        if ($validasi->fails()) {
            return $this->error('Kesalahan: ' . $validasi->errors()->first());
        }

        $user = User::where('email', $request->email)->with('userRole')->first();

        if ($user) {
            if (password_verify($request->password, $user->password)) {
                $token = PersonalToken::create([
                    'token' => $this->generateToken(),
                    'userId' => $user->id
                ]);

                $user->token = $token->token;
                return $this->success($user, 'Selamat datang di Finding ' . $user->name);
            } else {
                return $this->error('Email or Password salah');
            }
        }
        return $this->error('Kesalahan: ' . $validasi->errors()->first());
    }

    public function register(Request $request){
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'kota' => 'required',
            'tgllahir' => 'required',
            'password' => 'required|min:6'
        ]);

        if ($validasi->fails()) {
            return $this->error('Kesalahan: '.$validasi->errors()->first());
        }

        $user = User::create(array_merge($request->all(),[
            'password' => bcrypt($request->password)
        ]));

        if ($user) {
            return $this->success($user, 'Akun anda '. $user->name. ' berhasil terdaftar');
        } else {
            return $this->error('Kesalahan: '.$validasi->errors()->first());
        }
    }

    public function update(Request $request, $id){
        $user = User::where('id', $id)->first();
        if ($user){
            $user->update($request->all());
            return $this->success($user);
        }
        return $this->error("Pengguna tidak di temukan");
    }
    public function upload(Request $request, $id){
        $user = User::where('id', $id)->first();
        if ($user){
            $fileName ="";
            if($request->image){
                $image = $request->image->getClientOriginalName();
                $image = str_replace(' ', '', $image);
                $image = date('Hs') . rand(1,999) . "_" . $image;
                $fileName = $image;
                $request->image->storeAs('public/user', $image);
            }else{
                return $this->error("Image wajib di kirim");
            }
            $user->update([
                'image' => $fileName
            ]);
            return $this->success($user);
        }
        return $this->error("Pengguna tidak di temukan");
    }

}
