<?php

use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\ManController;
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
Route::get('/getList', function () {
    return view('index');
})->name('indexPatient');
Route::get('/', function () {
    return view('start');
})->name('start');
Route::post('/index/patient', [ChronicPainController::class, 'cretatePatientIndex'])->name('index');
Route::middleware(['set_locale'])->group(function () {

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
Route::get('locale/{locale}', [ChronicPainController::class, 'changeLocale'])->name('locale');

Route::get('/callback', function () {
    return view('callback');
})->name('callback');
Route::get('/detect', [ManController::class, 'getMan'])->name('detect');
Route::get('/vision', [ManController::class, 'getManVision'])->name('vision');
Route::get('/get-vision', [ManController::class, 'getForm'])->name('get-vision');
Route::post('/save-image', [ManController::class, 'saveImage']);
Route::post('/upload-image', [ImageUploadController::class, 'store']);
Route::post('/submit-measurement', [ManController::class, 'saveVision'])->name('submit-measurement');
Route::post('/save-level-pain', [ImageUploadController::class, 'createPainLevel'])->name('save-level-pain');
Route::get('/getData', [ImageUploadController::class, 'getData'])->name('getData');
Route::get('/getCamera', [ImageUploadController::class, 'getCamera'])->name('getCamera');



