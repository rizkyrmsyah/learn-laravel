<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SessionController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/health', function(){
    return response()->json(["message" => "hello world"]);
});

Route::post('login', [SessionController::class, 'auth']);


Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::Post('logout', [SessionController::class, 'logout']);

    Route::apiResource('authors', AuthorController::class);
    Route::apiResource('books', BookController::class);
    Route::apiResource('categories', CategoryController::class);
});

