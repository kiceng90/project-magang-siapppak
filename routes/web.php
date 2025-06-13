<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

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

Route::get('cek',[Controller::class,'cek']);   

Route::get('/preview-satgas-ppa', function () {
    return view('pdf.cetakSatgasPPA');
});

Route::any('/dashboard/{all}', function () {
    return view('dashboard');
})->where('all', '^(?!api).*$');

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/login', function () {
    return view('dashboard');
});

Route::get('/registrasi-konseling', function () {
    return view('dashboard');
});

Route::get('/registrasi-mahasiswa', function () {
    return view('dashboard');
});

Route::get('/buku-tamu', function () {
    return view('dashboard');
});

Route::get('/pilihan', function () {
    return view('dashboard');
});

Route::get('/upload-OCR', function () {
    return view('dashboard');
});

Route::get('/buku-tamu-OCR/{id}', function ($id) {
    return view('dashboard');
});

Route::get('/', function () {
    return view('landing');
});

Route::any('/{all}', function () {
    return view('landing');
})->where('all', '^(?!api).*$');
 