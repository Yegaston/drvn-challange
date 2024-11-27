<?php

use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserAuthController;
use App\Http\Middlewares\CheckUserRoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    Route::get('/health', function () {
        return response()->json(['status' => 'ok']);
    });

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/register', [UserAuthController::class, 'register']);

    Route::post('/logout', [UserAuthController::class, 'logout']);
    Route::post('/refresh', [UserAuthController::class, 'refresh']);

    Route::post('/change-role/{user}', [UserAuthController::class, 'changeUserRole'])
        ->middleware('auth:sanctum')
        ->middleware(CheckUserRoleMiddleware::class . ':admin');

    Route::apiResource('/posts', PostController::class)
        ->middleware('auth:sanctum');

    Route::apiResource('/post-comments', PostCommentController::class)
        ->middleware('auth:sanctum');

    Route::get('/post-comments/post/{postId}', [PostCommentController::class, 'getByPostId'])
        ->middleware('auth:sanctum');
});
