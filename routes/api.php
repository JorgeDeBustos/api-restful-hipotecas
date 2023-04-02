<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

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


Route::get('/clientes', [ClienteController::class, 'index']);
Route::get('/clientes/{dni}', [ClienteController::class, 'show']);
Route::post('/clientes', [ClienteController::class, 'store']);
Route::put('/clientes/{dni}', [ClienteController::class, 'update']);
Route::delete('/clientes/{dni}', [ClienteController::class, 'destroy']);
Route::post('/simulacion-hipoteca/{dni}', [ClienteController::class, 'simulacionHipoteca']);
