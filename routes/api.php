<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BookController;
use App\Http\Controllers\Api\V1\BorrowRecordsController;
use App\Http\Controllers\Api\V1\UserController;
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

Route::prefix('v1')->group( function() {
    Route::controller(AuthController::class)-> group(function () {
                /**
         * Login Route
         *
         * @method POST
         * @route /v1/login
         * @desc Authenticates a user and returns a JWT token.
         */
        Route::post('login', 'login');
                /**
         * Register Route
         *
         * @method POST
         * @route /v1/register
         * @desc Registers a new user and returns a JWT token.
         */
        Route::post('register', 'register');
                /**
         * Logout Route
         *
         * @method POST
         * @route /v1/logout
         * @desc Logs out the authenticated user.
         * @middleware auth:api
         */
        Route::post('logout','logout')->middleware('auth:api');
    });

    /**
     * Api Route Resource
     * 
     * Users
     */

    Route::apiResource('users', UserController::class)->middleware('auth:api');
    Route::apiResource('books', BookController::class)->middleware('auth:api');
    Route::apiResource('borrow-records', BorrowRecordsController::class)->middleware('auth:api');
});
