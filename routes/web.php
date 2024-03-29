<?php

use App\Http\Controllers\jadwal;
use App\Http\Controllers\jadwal_controller;
use App\Http\Controllers\user_controller;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('app');
// });

Route::group(['middleware' => 'auth'], function () {
   
    Route::get('/ganti_password', [user_controller::class, 'tampil_ganti_password']);
    Route::post('/ganti_password', [user_controller::class, 'ganti_password']);

    Route::group(['middleware' => 'user'], function () { 
        Route::get('/',  [user_controller::class, 'dashboard']);
        Route::get('/profil',  [user_controller::class, 'tampil_profil']);
        Route::get('/tolak_berkas/{id}',  [user_controller::class, 'tolak_berkas']);
        Route::get('/terima_berkas/{id}',  [user_controller::class, 'terima_berkas']);
    
        Route::get('/dashboard', [user_controller::class, 'dashboard']);
        Route::post('/dashboard', [user_controller::class, 'filter']);
    
        Route::get('/list_peserta',[user_controller::class,'list_peserta']);
        Route::post('/tambah_peserta', [user_controller::class, 'tambah_peserta']);

        Route::post('/upload_berkas', [user_controller::class, 'upload_berkas']);
    
        Route::get('/list_jadwal',[jadwal_controller::class,'list_jadwal']);
        Route::get('/peserta_ujian',[jadwal_controller::class,'jadwal_peserta']);
        Route::post('/peserta_ujian',[jadwal_controller::class,'jadwal_peserta']);
        Route::post('/add_link',[jadwal_controller::class,'add_link']);
        Route::post('/tambah_jadwal', [jadwal_controller::class, 'tambah_jadwal']);
        Route::post('/hapus_jadwal', [jadwal_controller::class, 'hapus_jadwal']);
        Route::post('/simpan_jadwal', [jadwal_controller::class, 'simpan_jadwal']);
        Route::post('/hapus_ujian', [jadwal_controller::class, 'hapus_ujian']);
        Route::get('/logout', [user_controller::class, 'logout']);
    
    });
});

Route::get('/login', [user_controller::class, 'tampil_login'])->name("login");
Route::post('/login', [user_controller::class, 'login']);

Route::get('/dummy',[user_controller::class,'create_user']);
