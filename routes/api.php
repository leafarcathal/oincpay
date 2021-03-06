<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\WalletController;
use App\Http\Controllers\API\TransactionController;

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

Route::get('/authenticate', [AuthController::class, 'authenticate']);
Route::post('/wallet/', [WalletController::class, 'get'])->middleware(['accessCode','permission']);
Route::post('/transaction', [TransactionController::class, 'make'])->middleware(['accessCode','permission']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
