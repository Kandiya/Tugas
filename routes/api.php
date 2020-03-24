<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', 'Petugascontroller@register');
Route::post('login', 'Petugascontroller@login');
    Route::get('/', function(){
        return Auth::user()->level;
    })->middleware('jwt.verify');

    Route::get('user', 'Petugascontroller@getAuthenticatedUser');


Route::post('/simpan_pelanggan', 'Pelanggancontroller@store')->middleware('jwt.verify'); 
Route::put('/ubah_pelanggan/{id}', 'Pelanggancontroller@update')->middleware('jwt.verify');
Route::delete('/hapus_pelanggan/{id}', 'Pelanggancontroller@destroy')->middleware('jwt.verify');
Route::get('/tampil_pelanggan', 'Pelanggancontroller@tampil')->middleware('jwt.verify');

Route::post('/simpan_jenis', 'Jeniscontroller@store')->middleware('jwt.verify');
Route::put('/ubah_jenis/{id}', 'Jeniscontroller@update')->middleware('jwt.verify');
Route::delete('/hapus_jenis/{id}', 'Jeniscontroller@destroy')->middleware('jwt.verify');
Route::get('/tampil_jenis', 'Jeniscontroller@tampil')->middleware('jwt.verify');

Route::post('/simpan_transaksi', 'Transaksicontroller@store')->middleware('jwt.verify');
Route::put('/ubah_transaksi/{id}', 'Transaksicontroller@update')->middleware('jwt.verify');
Route::delete('/hapus_transaksi/{id}', 'Transaksicontroller@destroy')->middleware('jwt.verify');
Route::get('/tampil_transaksi', 'Transaksicontroller@tampil')->middleware('jwt.verify');

Route::get('/report/{tgl_transaksi}/{tgl_selesai}', 'Transaksicontroller@report')->middleware('jwt.verify');

Route::post('/simpan_detail', 'Transaksicontroller@simpan')->middleware('jwt.verify');
Route::put('/ubah_detail/{id}', 'Transaksicontroller@ubah')->middleware('jwt.verify');
Route::delete('/hapus_detail/{id}', 'Transaksi controller@hapus')->middleware('jwt.verify');
