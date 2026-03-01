<?php

return [

    'defaults' => [
        'guard' => 'web', // По умолчанию остаются обычные пользователи
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // ДОБАВЛЯЕМ ЭТО: Новый охранник для больниц
        'hospital' => [
            'driver' => 'session',
            'provider' => 'hospitals',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // ДОБАВЛЯЕМ ЭТО: Указываем, откуда брать данные больниц
        'hospitals' => [
            'driver' => 'eloquent',
            'model' => App\Models\Hospital::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        // Опционально: можно добавить сброс пароля и для больниц
        'hospitals' => [
            'provider' => 'hospitals',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
