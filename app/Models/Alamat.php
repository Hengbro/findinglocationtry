<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;
    protected $fillable = [
        'IdUser',
        'label',
        'nama_alamat',
        'provinsi',
        'kota',
        'kecamatan',
        'infolainya_alamat',
    ];
}
