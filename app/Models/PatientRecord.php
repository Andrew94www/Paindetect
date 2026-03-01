<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'name',  // Додайте це
        'age',        // Додайте це
        'history_id',  // Додайте це
        'icd_codes',
        'predictors',
        'scores'
    ];

    /**
     * Автоматическое приведение типов (Casting)
     */
    protected $casts = [
        'icd_codes' => 'array',
        'predictors' => 'array',
        'scores' => 'array',
        'hospital_id' => 'string',
    ];

    public function hospital()
    {
        // Запись "принадлежит" госпиталю
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }
}
