<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\Pengunjung;
use App\Models\User;
use App\Models\Tempat;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PengunjungController extends Controller
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

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'userId' => 'required',
            'tempatId' => 'required',
        ]);

        if ($validasi->fails()) {
            return $this->error('Kesalahan: ' . $validasi->errors()->first());
        }

        $userId = $request->input('userId');
        $tempatId = $request->input('tempatId');
        $user = User::find($userId);
        $umurUser = Carbon::parse($user->tgllahir)->diffInYears(Carbon::now());

        $pengunjung = Pengunjung::where('userId', $userId)
            ->where('tempatId', $tempatId)
            ->first();

        if ($pengunjung) {
            $pengunjung->qtyKunjungan += 1;
            $pengunjung->tgllahirUser = $user->tgllahir;
            $pengunjung->umurUser = $umurUser;
            $pengunjung->save();
            return $this->success($pengunjung);

        } else {
            

            $qtyKunjungan = $request->input('qtyKunjungan') + 1;
            $pengunjung = new Pengunjung();
            $pengunjung->userId = $userId;
            $pengunjung->tempatId = $tempatId;
            $pengunjung->tgllahirUser = $user->tgllahir;
            $pengunjung->umurUser = $umurUser;
            $pengunjung->qtyKunjungan = $qtyKunjungan;
            $pengunjung->save();
            return $this->success($pengunjung);
        }
    }
    
    public function show($id)
    {
        
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

    public function showPlace($userId = null){
        if ($userId !== null) {
            $user = User::find($userId);
            $umurUser = Carbon::parse($user->tgllahir)->diffInYears(Carbon::now());
            $data = Pengunjung::with(['place'])
                ->where('umurUser', $umurUser)
                ->get();
        } else {
            $data = Pengunjung::with(['place'])->get();
        }
        
        return $this->success($data);
    }
}
