<?php

namespace App\Models;

// Важно: импортируем базовый класс для аутентификации
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Hospital extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'hospital_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token', // Полезно добавить, если будете использовать галочку "Запомнить меня"
    ];

    public function records()
    {
        // У госпиталя "много" записей
        return $this->hasMany(PatientRecord::class, 'hospital_id');
    }
}
