<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChronicPainController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::get('/chronicpain', function () {
    return view('chronicpain');
});
Route::get('/paindetect', function () {
    return view('paindetect');
});
Route::post('/paind', [ChronicPainController::class, 'cretatePatient'])->name('paindetect');
Route::post('/index/patient', [ChronicPainController::class, 'cretatePatientIndex'])->name('index');
