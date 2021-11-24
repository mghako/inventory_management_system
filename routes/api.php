<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Item\ItemController;

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


// Auth
Route::prefix('v1/auth')->group(function() {
    Route::post('/sanctum/token', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
});


// Logout


// API Resources
Route::middleware('auth:sanctum')->prefix('v1')->group(function() {
    Route::get('items', [ItemController::class, 'index'])->middleware('abilities:item:read');
    Route::get('items/{item}', [ItemController::class, 'show'])->middleware('abilities:item:read');;
    Route::post('items', [ItemController::class, 'store'])->middleware('abilities:item:write');
    Route::put('items/{item}', [ItemController::class, 'update'])->middleware('abilities:item:write');
    Route::delete('items/{item}', [ItemController::class, 'destroy'])->middleware('abilities:item:write');
});