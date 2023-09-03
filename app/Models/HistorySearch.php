<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorySearch extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId',
        'name',
        'isActive',
    ];
    protected $casts = [
        'isActive' => 'boolean'
    ];
}
