<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('main');
});
Route::get('/asset/{file}', [AssetsController::class, 'serve'] )->where("file",".*");

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
 
    return ['token' => $token->plainTextToken];
});

Route::post('/auth/login',[AuthController::class, 'login']);
Route::post('/auth/logout',[AuthController::class, 'logout']);
Route::get('/auth/hash',[AuthController::class, 'hash']);


Route::get('/{vue_capture?}', function() {
    return view('main');
})->where('vue_capture', '[\/\w\.-]*');