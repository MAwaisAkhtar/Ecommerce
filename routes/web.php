<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('auth/google',[GoogleController ::class,'googlepage']);
Route::get('auth/google/callback',[GoogleController::class,'googlecallback']);


Route::get('/',[HomeController::class,'index'])->name('/');
Route::get('/redirect',[HomeController::class,'redirect'])->name('redirect')->middleware('auth','verified');
Route::get('/product_detail/{id}',[HomeController::class,'product_detail'])->name('product_detail');
Route::post('/add_cart/{id}',[HomeController::class,'add_cart'])->name('add_cart');
Route::get('/show_cart',[HomeController::class,'show_cart'])->name('show_cart');
Route::get('/remove_cart/{id}',[HomeController::class,'remove_cart'])->name('remove_cart');
Route::get('/cash_order',[HomeController::class,'cash_order'])->name('cash_order');
Route::get('/stripe/{total_payment}',[HomeController::class,'stripe'])->name('stripe');
Route::post('/stripe/{total_payment}',[HomeController::class,'stripePost'])->name('stripe.post');
Route::get('/show_order',[HomeController::class,'show_order'])->name('show_order');
Route::get('/cancel_order/{id}',[HomeController::class,'cancel_order'])->name('cancel_order');
Route::post('/add_comment',[HomeController::class,'add_comment'])->name('add_comment');
Route::post('/add_reply',[HomeController::class,'add_reply'])->name('add_reply');
Route::post('/product_search',[HomeController::class,'product_search'])->name('product_search');
Route::get('/products',[HomeController::class,'products'])->name('products');
Route::get('/products_cat{id}',[HomeController::class,'products_cat'])->name('products_cat');
Route::get('/products_sale',[HomeController::class,'products_sale'])->name('products_sale');
Route::post('/search_product',[HomeController::class,'search_product'])->name('search_product');
Route::post('/subscribe',[HomeController::class,'subscribe'])->name('subscribe');

Route::get('/category',[AdminController::class,'category'])->name('category');
Route::post('/add_category',[AdminController::class,'add_category'])->name('add_category');
Route::get('/dlt_cat/{id}',[AdminController::class,'dlt_cat'])->name('dlt_cat');

Route::get('/pro',[AdminController::class,'product'])->name('product');
Route::post('/add_product',[AdminController::class,'add_product'])->name('add_product');
Route::get('/showProduct',[AdminController::class,'showProduct'])->name('show_product');
Route::get('/delete_product/{id}',[AdminController::class,'delete_product'])->name('delete_product');
Route::get('/update_product/{id}',[AdminController::class,'update_product'])->name('update_product');
Route::post('/upd_pro/{id}',[AdminController::class,'upd_pro'])->name('upd_pro');
Route::get('/order',[AdminController::class,'order'])->name('order');
Route::get('/delivered/{id}',[AdminController::class,'delivered'])->name('delivered');
Route::get('/print_pdf/{id}',[AdminController::class,'print_pdf'])->name('print_pdf');
Route::get('/send_email/{id}',[AdminController::class,'send_email'])->name('send_email');
Route::post('/send_user_email/{id}',[AdminController::class,'send_user_email'])->name('send_user_email');
Route::get('/search',[AdminController::class,'search'])->name('search');
