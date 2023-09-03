<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class KeranjangTempat extends Model
{
    use HasFactory;
    protected $fillable = [
        'tempatId',
        'userId',
        'productId',
        'sum_qty',
        'sum_harga',
        'lastInsert',
        'isActive',
    ];
    protected $casts = [
        'isActive'=> 'boolean',
        'isStatusBuy' => 'boolean'
    ];

    public function user(): HasOne{
        return $this->hasOne(User::class, "id", "userId");
    }

    public function place(): HasOne{
        return $this->hasone(Tempat::class, "id", "tempatId");
    }

    public function product(): HasOne{
        return $this->hasone(ProdukTemp::class, "productId", "id");
    }

}
