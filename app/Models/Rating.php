<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId',
        'tempatId',
        'comfort',
        'cleanliness',
        'service',
        'location',
        'price',
        'review',
        'qtyReview',
        'isActive',

    ];
    protected $casts = [
        'isActive' => 'boolean'
    ];

    public function user(): HasOne{
        return $this->hasOne(User::class, "id", "userId");
    }

    public function place(): HasOne{
        return $this->hasOne(Tempat::class, "id", "tempatId");
    }

    public function tempat()
    {
        return $this->belongsTo(Tempat::class, 'tempatId');
    }
}
