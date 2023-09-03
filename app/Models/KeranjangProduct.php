<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class KeranjangProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'cartPlaceId',
        'tempatId',
        'userId',
        'productId',
        'qty',
        'tot_harga',
        'note',
        'isActive',
        'isOrder',
    ];
    protected $casts = [
        'isActive' => 'boolean',
        'isOrder' => 'boolean'
    ];

    public function user(): HasOne{
        return $this->hasOne(User::class, "id", "userId");
    }

    public function place(): HasOne{
        return $this->hasone(Tempat::class, "id", "tempatId");
    }
    
    public function product(): HasOne{
        return $this->hasone(ProdukTemp::class, "id", "productId");
    }
}
