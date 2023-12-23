<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RouteController;

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
//get
Route::get('productlist',[RouteController::class,'productList']);
Route::get('categorylist',[RouteController::class,'categoryList']);

Route::post('create/category',[RouteController::class,'createCategory']);
Route::post('create/contact',[RouteController::class,'createContact']);
Route::get('contact/list',[RouteController::class,'contactList']);
Route::post('category/delete',[RouteController::class,'categoryDelete']);
Route::get('category/detail/{id}',[RouteController::class,'categoryDetail']);
Route::post('category/update',[RouteController::class,'categoryUpdate']);
