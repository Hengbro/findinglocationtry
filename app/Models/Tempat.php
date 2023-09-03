<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tempat extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId',
        'alamatId',
        'categoriId',
        'nameTempat',
        'email',
        'phone',
        'kota',
        'alamat',
        'imageTempat',
        'openH',
        'closeH',
        'kategori',
        'imagaPemilik',
        'deskription',
        'status',
        'pengunjung',
        'avgReview',
        'isActive',
    ];
    protected $casts = [
        'isActive' => 'boolean'
    ];

    public function category(): HasOne{
        return $this->hasOne(Category::class, "id", "kategoriId");
    }

    public function address(): HasOne{
        return $this->hasOne(LokasiTempat::class, "id", "alamatId");
    }

    public function user(): HasOne{
        return $this->hasOne(User::class, "id", "userId");
    }

    public function ulasan(){
        return $this->hasOne(Rating::class, "tempatId");
    }

}
