<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class PainRecord extends Model
{
    use HasFactory;
    protected $fillable = ['image', 'pain_level', 'medications','painIndex','age','weight','height'];

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }

}
