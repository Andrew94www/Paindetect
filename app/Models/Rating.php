<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'code',
        'totalScore',
        'department',
        'data',
    ];

    /**
     * Преобразование типов (Casting)
     */
    protected $casts = [
        'data' => 'array', // Автоматически превращает JSON из БД в массив PHP
    ];
}
