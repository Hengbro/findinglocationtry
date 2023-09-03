<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'storeId',
        'userId',
        'productId',
        'qty',
        'harga_tot',
        'note',
        'isSelected',
    ];
    protected $casts = [
        'isSelected' => 'boolean'
    ];
}
