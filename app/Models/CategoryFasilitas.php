<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryFasilitas extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'image',
        'parentId',
        'isActive',
    ];
    protected $casts = [
        'isActive' => 'boolean'
    ];
}
