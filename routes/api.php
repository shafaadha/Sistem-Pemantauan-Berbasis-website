<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use App\Http\Controllers\API\AccessController;
use App\Http\Controllers\API\SlotController;
use App\Http\Controllers\API\ValidationController;

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
Route::post('/valid-In', [AccessController::class, 'processIn']);

Route::post('/valid-Out', [AccessController::class, 'processOut']);

Route::get('/slot', [SlotController::class, 'slotCount']);

Route::post('/cekqr_in', [ValidationController::class, 'scanIn']);
Route::post('/cekqr_out', [ValidationController::class, 'scanOut']);
Route::post('/plat_in', [ValidationController::class, 'platIn']);
Route::post('/plat_out', [ValidationController::class, 'platOut']);

