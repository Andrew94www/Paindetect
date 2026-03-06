<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'patient_data',
        'prosthetics_data',
        'history_id',  // Додайте це
        'icd_codes',
        'predictors',
        'scores'
    ];

    /**
     * Автоматическое приведение типов (Casting)
     */
    protected $casts = [
        'patient_data'=>'array',
        'icd_codes' => 'array',
        'predictors' => 'array',
        'scores' => 'array',
        'prosthetics_data' => 'array',
        'hospital_id' => 'string',
    ];

    public function hospital()
    {
        // Запись "принадлежит" госпиталю
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }
}
