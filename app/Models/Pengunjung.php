<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengunjung extends Model
{
    use HasFactory;
    protected $fillable = [
        'tempatId',
        'userId',
        'tgllahirUser',
        'umurUser',
        'qtyKunjungan'
    ];
    public function place(){
        return $this->belongsTo(Tempat::class, 'tempatId');
    }

    public function user():HasOne{
        return $this->hasOne(User::class, "userId", "id");
    }
}
