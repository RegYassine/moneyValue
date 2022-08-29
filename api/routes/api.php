<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\PairController;
use App\Http\Controllers\RegisterController;
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


/** AUTH */
Route::controller(RegisterController::class)->group(function(){
    Route::post('login', 'login');
});



Route::get('/ping', function () {
    return response('API deployed', 200)->header('Content-Type', 'text/plain');
});


Route::middleware(['auth:sanctum'])->group( function () {

    /** Get count */
    Route::controller(PairController::class)->group(function() {
        Route::get('analytics', 'analytics');
    });

    /** API ressource for PAIR CRUD */
    Route::apiResources([
        'pairs' => PairController::class,
        'currencies' => CurrencyController::class,
    ]);

    Route::controller(RegisterController::class)->group(function(){
        Route::post('logout', 'logout');
    });
});


/** CONVERTION */
Route::controller(PairController::class)->group(function(){
    Route::post('pairs/convert', 'convertCurrencies');
});
