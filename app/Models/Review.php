<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId',
        'tempatId',
        'qtyReview',

    ];
    public function user(): HasOne{
        return $this->hasOne(User::class, "id", "userId");
    }

    public function place(): HasOne{
        return $this->hasOne(Tempat::class, "id", "tempatId");
    }
}
