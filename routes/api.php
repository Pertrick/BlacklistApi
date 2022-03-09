<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;

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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::get('file-import-export', [ProductController::class, 'fileImportExport']);

Route::get('file-export', [ProductController::class, 'fileExport'])->name('file-export');

Route::group(['middleware' => ['api']], function(){

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('file-import', [ProductController::class, 'fileImport'])->name('file-import');
    //products
    Route::post('create-product', [ProductController::class, 'create']);
    Route::put('edit-product/{id}', [ProductController::class, 'update']);
    Route::delete('delete-product/{id}', [ProductController::class, 'destroy']);
   
   
    Route::post('create-category', [CategoryController::class, 'create']);
    Route::put('edit-category/{id}', [CategoryController::class, 'update']);
    Route::delete('delete-category/{id}', [CategoryController::class, 'destroy']);

    
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
