<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tasks/list', [TasksController::class,"list"]);
Route::post('/tasks/create', [TasksController::class,"create"]);
Route::post('/tasks/done/toggle', [TasksController::class,"done_toggle"]);
Route::post('/tasks/set/text', [TasksController::class,"set_text"]);
