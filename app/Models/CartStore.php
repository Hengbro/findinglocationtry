<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CartStore extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId',
        'storeId',
        'lastInsert',
        'status',
        'much_product',
        'really_price',
        'isSelected',
        'isActive',
    ];
    protected $casts = [
        'isSelected' => 'boolean',
        'isActive' => 'boolean',
    ];

    public function user(): HasOne{
        return $this->hasOne(User::class, "id", "userId");
    }

    public function items(): HasMany{
        return $this->hasMany(CartProduct::class, "storeId", "id");
    }

}
