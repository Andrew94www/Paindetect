<?php

use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\ManController;
use App\Http\Controllers\RegisterController;
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
Route::middleware('auth')->group(function () {
    Route::get('/getList', function () {
        return view('index');
    })->name('indexPatient');

    Route::get('/', function () {
        return view('start');
    })->name('start');

    Route::get('/lending', function () {
        return view('lending');
    })->name('lending');

    Route::get('/lending-min', function () {
        return view('/lending-min');
    })->name('lending');

    Route::get('locale/{locale}', [ChronicPainController::class, 'changeLocale'])->name('locale');

    Route::get('/callback', function () {
        return view('callback');
    })->name('callback');

    Route::middleware(['set_locale'])->group(function () {
        Route::get('/chronicpain', function () {
            return view('chronicpain');
        })->name('chronicpain');

        Route::get('/paindetect', function () {
            return view('paindetect');
        })->name('pain');

        Route::post('/paind', [ChronicPainController::class, 'cretatePatient'])->name('paindetect');
        Route::post('/index/pain', [ChronicPainController::class, 'cretatePatientPainDetect'])->name('createpatient');
    });

    Route::post('/index/patient', [ChronicPainController::class, 'cretatePatientIndex'])->name('index');

    Route::get('/detect', [ManController::class, 'getMan'])->name('detect');
    Route::get('/vision', [ManController::class, 'getManVision'])->name('vision');
    Route::get('/get-vision', [ManController::class, 'getForm'])->name('get-vision');
    Route::post('/save-image', [ManController::class, 'saveImage']);
    Route::post('/upload-image', [ImageUploadController::class, 'store']);
    Route::post('/submit-measurement', [ManController::class, 'saveVision'])->name('submit-measurement');
    Route::post('/save-level-pain', [ImageUploadController::class, 'createPainLevel'])->name('save-level-pain');
    Route::get('/getData', [ImageUploadController::class, 'getData'])->name('getData');
    Route::get('/getCamera', [ImageUploadController::class, 'getCamera'])->name('getCamera');
    Route::get('/interaction', [ImageUploadController::class, 'getInteraction'])->name('interaction');
    Route::get('/protesys', [ImageUploadController::class, 'getProtesys'])->name('protesys');
    Route::get('/tcare', [ImageUploadController::class, 'getTCare'])->name('tcare');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Login routes
Route::get('/login', [RegisterController::class, 'showLoginForm'])->name('login');
Route::post('/login', [RegisterController::class, 'login']);

// Logout route
Route::post('/logout', [RegisterController::class, 'logout'])->name('logout');

// Example route after successful registration/login
Route::get('/home', function () {
    return 'Welcome to the home page! You are logged in as: ' . Auth::user()->name;
})->middleware('auth');



