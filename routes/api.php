<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function() {
    Route::post("/login", "login")->name("login");
    Route::post("/register", "register")->name("register");
    Route::get("/data", function() {    
        return response()->json([
            'data'=> 'data'
        ]);
    });
});

Route::controller(CategoryController::class)->middleware('auth.jwt')->prefix('category')->group(function() {
    Route::get("/", 'index')->name('category.index');
    Route::get("/{id}", 'show')->name('category.show');
    Route::post("store", 'store')->name('category.store');
    Route::put("update/{id}", 'update')->name('category.update');
    Route::delete("delete/{id}", 'destroy')->name('category.delete');
});