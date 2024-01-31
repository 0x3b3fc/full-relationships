<?php

use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\PhoneController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\RolesController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//one to one relationship
Route::apiResource('user', UserController::class);
Route::apiResource('phone', PhoneController::class);

Route::apiResource('post', PostController::class);
Route::apiResource('comment', CommentController::class);

Route::controller(RolesController::class)->prefix('roles')->group(function () {
    Route::get('all', 'index');
    Route::post('create', 'store');
});

Route::get('user-sync-role', [UserController::class, 'sync'])->name('user.sync.role');
