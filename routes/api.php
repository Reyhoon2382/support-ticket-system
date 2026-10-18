<?php

use App\Http\Controllers\Api\ApiTicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/tickets', [ApiTicketController::class, 'index']);
    Route::post('/tickets', [ApiTicketController::class, 'store']);
    Route::get('/tickets/{ticket}', [ApiTicketController::class, 'show']);
});
