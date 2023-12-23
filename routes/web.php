<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\UserController;

//for pizza order system
//login , register
Route::middleware(['admin_auth'])->group(function(){
    Route::redirect('/', 'loginPage',);
    Route::get('loginPage', [AuthController::class, 'loginPage'])->name('auth#loginPage');
    Route::get('registerPage', [AuthController::class, 'registerPage'])->name('auth#registerPage');
});

Route::middleware(['auth','check_banned'])->group(function () {
    //dashboard
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    //admin
    Route::middleware(['admin_auth'])->group(function () {
        //category
        Route::prefix('category')->group(function () {
            Route::get('list', [CategoryController::class, 'list'])->name('category#list');
            Route::get('create/page', [CategoryController::class, 'createPage'])->name('category#createPage');
            Route::post('create', [CategoryController::class, 'create'])->name('category#create');
            Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('category#delete');
            Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category#edit');
            Route::post('update', [CategoryController::class, 'update'])->name('category#update');
        });
        //admin account
        Route::prefix('admin')->group(function () {
            //password
            Route::get('password/changePage', [AdminController::class, 'changePasswordPage'])->name('admin#changePasswordPage');
            Route::post('change/password', [AdminController::class, 'changePassword'])->name('admin#changePassword');
            //profile
            Route::get('details',[AdminController::class,'details'])->name('admin#details');
            Route::get('edit',[AdminController::class,'edit'])->name('admin#edit');
            Route::post('update/{id}',[AdminController::class,'update'])->name('admin#update');
            //admin list
            Route::get('list',[AdminController::class,'list'])->name('admin#list');
            Route::get('user/details/{id}',[AdminController::class,'userDetails'])->name('admin#userDetails');
            Route::get('delete/{id}',[AdminController::class,'delete'])->name('admin#delete');
            Route::get('ban/{id}',[AdminController::class,'banUser'])->name('admin#banUser');
            Route::get('unban/{id}',[AdminController::class,'unbanUser'])->name('admin#UnbanUser');
            Route::get('ajax/changeRole',[AdminController::class,'changeRole'])->name('ajax#changeRole');
            Route::get('contactList',[AdminController::class,'contactList'])->name('admin#contactList');
            Route::get('contact/detail/{id}',[AdminController::class,'contactDetail'])->name('admin#contactDetail');
        });
        //products
        Route::prefix('products')->group(function(){
            Route::get('list',[ProductController::class,'list'])->name('products#list');
            Route::get('create',[ProductController::class,'createPage'])->name('product#createPage');
            Route::post('create',[ProductController::class,'create'])->name('product#create');
            Route::get('delete/{id}',[ProductController::class,'delete'])->name('product#delete');
            Route::get('edit/{id}',[ProductController::class,'edit'])->name('product#edit');
            Route::get('updatePage/{id}',[ProductController::class,'updatePage'])->name('product#updatePage');
            Route::post('update/{id}',[ProductController::class,'update'])->name('product#update');
        });
         //orders
         Route::prefix('orders')->group(function(){
            Route::get('list',[OrderController::class,'orderList'])->name('admin#orderList');
            Route::get('ajax/orderStatus',[OrderController::class,'orderStatus'])->name('admin#orderStatus');
            Route::get('ajax/changeStatus',[OrderController::class,'changeStatus'])->name('admin#changeStatus');
            Route::get('listInfo/{orderCode}',[OrderController::class,'listInfo'])->name('admin#listInfo');
        });
        Route::prefix('user')->group(function(){
            Route::get('list',[UserController::class,'userList'])->name('admin#userList');
            Route::get('ajax/changeRole',[UserController::class,'changeRole'])->name('user#changeRole');
            Route::get('delete/{id}',[UserController::class,'delete'])->name('user#delete');
        });
    });
    //user
    //home
    Route::group(['prefix' => 'user', 'middleware' => 'user_auth'], function () {
        Route::get('homePage',[UserController::class,'home'])->name('user#home');
        Route::get('filter/{id}',[UserController::class,'filter'])->name('user#filter');
        Route::get('history',[UserController::class,'history'])->name('user#history');
        //pizza details
        Route::prefix('pizza')->group(function(){
            Route::get('details/{id}',[UserController::class,'pizzaDetails'])->name('user#pizzaDetails');
        });
        //carts
        Route::prefix('cart')->group(function(){
            Route::get('list',[UserController::class,'cartList'])->name('user#cartList');
        });
        Route::prefix('password')->group(function(){
            Route::get('change',[UserController::class,'changePasswordPage'])->name('user#changePasswordPage');
            Route::post('change',[UserController::class,'changePassword'])->name('user#changePassword');
        });
        Route::prefix('account')->group(function(){
            Route::get('change',[UserController::class,'accountChangePage'])->name('user#accountChangePage');
            Route::post('change/{id}',[UserController::class,'accountChange'])->name('user#accountChange');
        });
        Route::prefix('ajax')->group(function(){
           Route::get('pizza/list',[AjaxController::class,'pizzaList'])->name('ajax#pizzaList');
           Route::get('addToCart',[AjaxController::class,'addToCart'])->name('ajax#addToCart');
           Route::get('order',[AjaxController::class,'order'])->name('ajax#order');
           Route::get('clear/cart',[AjaxController::class,'clearCart'])->name('ajax#clearCart');
           Route::get('clear/current/product',[AjaxController::class,'clearCurrentProduct'])->name('ajax#clearCurrentProduct');
           Route::get('increase/viewcount',[AjaxController::class,'increaseViewCount'])->name("ajax#increaseViewCount");
        });

        Route::get('contact',[ContactController::class,'contactPage'])->name('user#contactPage');
        Route::post('contact/send',[ContactController::class,'contactSend'])->name('contact#send');
    });
});
Route::get('webTesting',function() {
    $data = [
        'message'=>'this is web testing message',
    ];

    return response()->json($data,200);
});
