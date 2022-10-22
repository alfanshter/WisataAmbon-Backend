<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\WisataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/data_wisata', [WisataController::class, 'data_wisata']);
Route::get('/data_wisata_kategori', [WisataController::class, 'data_wisata_kategori']);
Route::post('/tambah_wisata', [WisataController::class, 'tambah_wisata']);
Route::post('/delete_wisata', [WisataController::class, 'delete_wisata']);

//event
Route::post('/tambah_event', [EventController::class, 'tambah_event']);
Route::get('/data_event', [EventController::class, 'data_event']);
Route::post('/delete_event', [EventController::class, 'delete_event']);
