<?php

use App\Http\Controllers\admin\ImageController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class,'index'])->name('home-page');


Route::group(['middleware' => 'verify-admin'], function() {
    // admin
    Route::get('/admin',[HomeController::class,'dashboard'])->name('admin-dashboard');

    // product
    Route::get('/products',[App\Http\Controllers\admin\ProductController::class,'index'])->name('admin.products.index');
    Route::get('/products/create',[App\Http\Controllers\admin\ProductController::class,'create'])->name('products.create');
    Route::post('/products/create',[App\Http\Controllers\admin\ProductController::class,'store'])->name('products.store');
    Route::get('/admin/products/{id}',[App\Http\Controllers\admin\ProductController::class,'show'])->name('products.show');
    Route::get('/products/edit/{id}',[App\Http\Controllers\admin\ProductController::class,'edit'])->name('products.edit');
    Route::post('/products/edit/{id}',[App\Http\Controllers\admin\ProductController::class,'update'])->name('products.update');
    Route::Delete('/products/delete/{id}',[App\Http\Controllers\admin\ProductController::class,'destroy'])->name('products.destroy');

    Route::post('/images/upload',[ImageController::class,'storeImage'])->name('images.upload');

    Route::get('/api/products',[App\Http\Controllers\admin\ProductController::class,'getProduct'])->name('api.products.get');


    // categories
    Route::get('/api/categories',[\App\Http\Controllers\admin\CategoryController::class,'getCategory'])->name('api.categories');
    Route::get('/api/dtb/categories',[\App\Http\Controllers\admin\CategoryController::class,'getCategoryData'])->name('api.categories.data');
    Route::get('/categories',[\App\Http\Controllers\admin\CategoryController::class,'index'])->name('categories.index');
    Route::get('/categories/create',[\App\Http\Controllers\admin\CategoryController::class,'create'])->name('categories.create');
    Route::post('/categories/create',[\App\Http\Controllers\admin\CategoryController::class,'store'])->name('categories.store');
    Route::get('/categories/edit/{id}',[\App\Http\Controllers\admin\CategoryController::class,'edit'])->name('categories.edit');
    Route::post('/categories/edit/{id}',[\App\Http\Controllers\admin\CategoryController::class,'update'])->name('categories.update');
    Route::post('/categories/delete/{id}',[\App\Http\Controllers\admin\CategoryController::class,'destroy'])->name('categories.delete');

    // sub-categories
    Route::get('/api/subCategories',[\App\Http\Controllers\admin\SubCategoryController::class,'getSubCategory'])->name('api.subCategories');
    Route::get('/api/dtb/subCategories',[\App\Http\Controllers\admin\SubCategoryController::class,'getSubCategoryData'])->name('api.subCategories.data');
    Route::get('/subCategories',[\App\Http\Controllers\admin\SubCategoryController::class,'index'])->name('subCategories.index');
    Route::get('/subCategories/create',[\App\Http\Controllers\admin\SubCategoryController::class,'create'])->name('subCategories.create');
    Route::post('/subCategories/create',[\App\Http\Controllers\admin\SubCategoryController::class,'store'])->name('subCategories.store');
    Route::get('/subCategories/edit/{id}',[\App\Http\Controllers\admin\SubCategoryController::class,'edit'])->name('subCategories.edit');
    Route::post('/subCategories/edit/{id}',[\App\Http\Controllers\admin\SubCategoryController::class,'update'])->name('subCategories.update');
    Route::post('/subCategories/delete/{id}',[\App\Http\Controllers\admin\SubCategoryController::class,'destroy'])->name('subCategories.delete');

    Route::get('/order/{status}/{page?}/{size?}',[\App\Http\Controllers\OrderController::class,'getOrderByStatus'])->name('order.getByStatus');
    Route::post('/order/confirm/{id}',[\App\Http\Controllers\OrderController::class,'confirm'])->name('order.confirm');
    Route::post('/order/cancel/{id}',[\App\Http\Controllers\OrderController::class,'cancel'])->name('order.cancel');
});

// singing
Route::get('/login',[\App\Http\Controllers\SigningController::class,'login'])->name('login');
Route::post('/login',[\App\Http\Controllers\SigningController::class,'signIn'])->name('signIn');
Route::get('/logout',[\App\Http\Controllers\SigningController::class,'signOut'])->name('signOut');
Route::get('/registration',[\App\Http\Controllers\SigningController::class,'registration'])->name('registration');
Route::post('/registration',[\App\Http\Controllers\SigningController::class,'signUp'])->name('signUp');
Route::get('/forgotPassword',[\App\Http\Controllers\SigningController::class,'forgotPassword'])->name('forgotPassword');
Route::post('/forgotPassword',[\App\Http\Controllers\SigningController::class,'sendMail'])->name('sendMail');

Route::group(['middleware' => 'exists-otp'],function (){
    Route::post('/api/forgotPassword',[\App\Http\Controllers\SigningController::class,'resendMail'])->name('resendMail');
    Route::get('/confirmOtp',[\App\Http\Controllers\SigningController::class,'confirmOtp'])->name('confirmOtp');
    Route::post('/confirmOtp',[\App\Http\Controllers\SigningController::class,'verifyOtp'])->name('verifyOtp');
    Route::get('/changePassword',[\App\Http\Controllers\SigningController::class,'editPassword'])->name('editPassword');
    Route::post('/changePassword',[\App\Http\Controllers\SigningController::class,'updatePassword'])->name('updatePassword');
});


//route for user
Route::get('/list-product',[App\Http\Controllers\landing\ProductController::class,'index'])->name('list-product');
Route::get('/products/{id}',[App\Http\Controllers\landing\ProductController::class,'show'])->name('landing.products.show');
Route::group(['middleware'=>'verify-login'],function (){
    Route::post('/addCart',[\App\Http\Controllers\landing\ProductController::class,'addToCart'])->name('addCart');
    Route::post('/buyNow',[\App\Http\Controllers\landing\ProductController::class,'buyNow'])->name('buyNow');

    Route::get('/cart',[\App\Http\Controllers\CartController::class,'index'])->name('cart.index');
    Route::post('/cart/delete',[\App\Http\Controllers\CartController::class,'delete'])->name('cart.delete');
    Route::post('/cart/update',[\App\Http\Controllers\CartController::class,'updateQuantity'])->name('cart.update');

    Route::get('/checkout',[\App\Http\Controllers\OrderController::class,'index'])->name('order.index');
    Route::post('/order',[\App\Http\Controllers\OrderController::class,'order'])->name('order.success');

});
