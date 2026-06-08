<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\BorrowingController;
use App\Http\Controllers\Api\FineController;

/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
/*
|--------------------------------------------------------------------------
| Authenticated Route
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    /*
    |--------------------------------------------------------------------------
    | User Route
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:user')->group(function () {
        Route::post('/borrowings', [BorrowingController::class, 'store']);
        Route::get('/my-borrowings', [BorrowingController::class, 'myBorrowings']);
    });
    /*
    |--------------------------------------------------------------------------
    | Admin Route
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {
        /*
        | Books
        */
        Route::apiResource('books', BookController::class);
        /*
        | Members
        */
        Route::get('/members', [MemberController::class, 'index']);
        Route::get('/members/{id}', [MemberController::class, 'show']);
        Route::delete('/members/{id}', [MemberController::class, 'destroy']);
        /*
        | Borrowings
        */
        Route::get('/borrowings', [BorrowingController::class, 'index']);
        Route::put('/borrowings/{id}/approve', [BorrowingController::class, 'approve']);
        Route::put('/borrowings/{id}/return', [BorrowingController::class, 'returnBook']);
        /*
        | Fine
        */
        Route::get('/fines', [FineController::class, 'index']);
    });
});