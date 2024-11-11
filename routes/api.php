<?php

use App\Http\Controllers\Api\AboutUsController;
use App\Http\Controllers\Api\Bazaar;
use App\Http\Controllers\Api\BazzarController;
use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\ImagesController;
use App\Http\Controllers\Api\LoginControlle;
use App\Http\Controllers\Api\PositionCasaController;
use App\Http\Controllers\Api\TransparencyController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ValuableController;
use Illuminate\Support\Facades\Route;

//  Route::post('/login', function (Request $request) {
//      return $request->user();
//  })->middleware('auth:sanctum');

Route::post('/login', [LoginControlle::class, 'login']);

// Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {

Route::get('/users', [UserController::class, 'index']);
Route::post('/logout/{user}', [LoginControlle::class, 'logout']);
Route::post('/user', [UserController::class, 'store']); //criar usuaio

Route::post('/image', [ImagesController::class, 'store'])->name('galeria');
Route::get('/image/index', [ImagesController::class, 'index']);
Route::delete('/image/{id}/delete', [ImagesController::class, 'destroy']);
Route::post('/image/{id}/update', [ImagesController::class, 'update']);

Route::post('/events', [EventsController::class, 'store'])->name('eventos');
Route::get('/events/index', [EventsController::class, 'index']);
Route::delete('/events/{id}/delete', [EventsController::class, 'destroy']);

Route::post('/bazzar', [BazzarController::class, 'store'])->name('bazaar');
Route::get('/bazzar/index', [BazzarController::class, 'index']);
Route::delete('/bazzar/{id}/delete', [BazzarController::class, 'destroy']);

Route::post('/position', [PositionCasaController::class, 'store']);
Route::put('/position/{id}/update', [PositionCasaController::class, 'update']);
Route::get('/position/index', [PositionCasaController::class, 'index']);
Route::delete('/position/{id}/delete', [PositionCasaController::class, 'destroy']);

Route::post('/about_us', [AboutUsController::class, 'store'])->name('about_us');
Route::put('/about_us/{id}/update', [AboutUsController::class, 'update']);
Route::get('/about_us/index', [AboutUsController::class, 'index']);
Route::get('/about_us/{id}', [AboutUsController::class, 'show']);


Route::post('/transparency', [TransparencyController::class, 'store'])->name('transparency');
Route::get('/transparency/index', [TransparencyController::class, 'index']);
Route::put('/transparency/{id}/update', [TransparencyController::class, 'update']);
Route::delete('/transparency/{id}/delete', [TransparencyController::class, 'destroy']);

Route::get('/valuable', [ValuableController::class, 'index']);
Route::post('/valuable/post', [ValuableController::class, 'store']);
Route::delete('/valuable/{id}/delete', [ValuableController::class, 'destroy']);
// });
