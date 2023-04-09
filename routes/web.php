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
// Route::middleware(['set_locale'])->group(function(){

// }
// );
Route::get('/', function () {
    return view('index');
})->name('index');
Route::post('/index/patient', [ChronicPainController::class, 'cretatePatientIndex'])->name('index');
Route::middleware(['set_locale'])->group(function(){

    Route::get('/chronicpain', function () {
        return view('chronicpain');
    })->name('chronicpain');

    Route::get('/paindetect', function () {
        return view('paindetect');
    })->name('pain');

    Route::post('/paind', [ChronicPainController::class, 'cretatePatient'])->name('paindetect');



    Route::post('/index/pain', [ChronicPainController::class, 'cretatePatientPainDetect'])->name('createpatient');

}
);
Route::get('locale/{locale}',[ChronicPainController::class ,'changeLocale'])->name('locale');

Route::get('/callback', function () {
    return view('callback');
})->name('callback');
