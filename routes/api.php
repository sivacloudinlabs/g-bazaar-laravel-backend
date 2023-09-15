<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ContentCategoryController;
use App\Http\Controllers\ContentTypeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('login', [AuthController::class, 'login']);

    // auth based routes
    Route::group(['middleware' => ['auth:api']], function () { 
        Route::resource('user', UserController::class);
        
        Route::resource('bank', BankController::class);
        Route::put('bank/{bank}/on-hold', [BankController::class, 'onHold']);
        Route::options('bank', [BankController::class, 'options']);

        Route::resource('ticket', TicketController::class);
        Route::put('ticket/update-status/{ticket}', [TicketController::class, 'updateStatus']);
        
        Route::resource('content-type', ContentTypeController::class);
        Route::put('content-type/{content_type}/on-hold', [ContentTypeController::class, 'onHold']);
        Route::options('content-type', [ContentTypeController::class, 'options']);
        Route::resource('content-type.content-category', ContentCategoryController::class);
        Route::put('content-type/{content_type}/content-category/{content_category}/on-hold', [ContentCategoryController::class, 'onHold']);
        Route::options('content-type/{content_type}/content-category', [ContentCategoryController::class, 'options']);
    });
});