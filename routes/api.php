<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ContentCategoryController;
use App\Http\Controllers\ContentTypeController;
use App\Http\Controllers\OfferCategoryController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OfferTypeController;
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

        // User
        Route::resource('user', UserController::class);

        // Bank
        Route::resource('bank', BankController::class);
        Route::put('bank/{bank}/on-hold', [BankController::class, 'onHold']);
        Route::options('bank', [BankController::class, 'options']);

        // Ticket
        Route::resource('ticket', TicketController::class);
        Route::put('ticket/update-status/{ticket}', [TicketController::class, 'updateStatus']);

        // Content Type
        Route::resource('content-type', ContentTypeController::class);
        Route::put('content-type/{content_type}/on-hold', [ContentTypeController::class, 'onHold']);
        Route::options('content-type', [ContentTypeController::class, 'options']);
        // Content Category
        Route::resource('content-type.content-category', ContentCategoryController::class);
        Route::put('content-type/{content_type}/content-category/{content_category}/on-hold', [ContentCategoryController::class, 'onHold']);
        Route::options('content-type/{content_type}/content-category', [ContentCategoryController::class, 'options']);

        // Offer Type
        Route::resource('offer-type', OfferTypeController::class);
        Route::put('offer-type/{offer_type}/on-hold', [OfferTypeController::class, 'onHold']);
        Route::options('offer-type', [OfferTypeController::class, 'options']);
        // Offer Category
        Route::resource('offer-type.offer-category', OfferCategoryController::class);
        Route::put('offer-type/{offer_type}/offer-category/{offer_category}/on-hold', [OfferCategoryController::class, 'onHold']);
        Route::options('offer-type/{offer_type}/offer-category', [OfferCategoryController::class, 'options']);
        // Offer
        Route::resource('offer', OfferController::class);
        Route::put('offer/{offer}/on-hold', [OfferController::class, 'onHold']);
    });
});