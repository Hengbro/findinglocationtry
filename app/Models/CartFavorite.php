<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CartFavorite extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId',
        'placeId',
        'note',
        'isActive',
    ];
    protected $casts = [
        'isActive' => 'boolean'
    ];
    public function place(): HasOne
    {
        return $this->hasOne(Tempat::class, "id", "placeId");
    }
    public function user(): HasOne
    {
        return $this->hasOne(User::class, "id", "userId");
    }
    public function address(): HasOne{
        return $this->hasOne(LokasiTempat::class, "id", "alamatId");
    }
}
