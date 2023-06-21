<?php
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::resource('posts', 'PostController');
Route::resource('offers', 'OfferController');
Route::resource('violations', 'ViolationController');
Route::resource('users', 'UserController');
Route::get('/violations/create/{violation}', 'ViolationController@create')->name('violations.create');
Route::get('/offers/create/{offer}', 'OfferController@create')->name('offers.create');
Route::get('/users/create/{user}', 'UserController@create')->name('users.create');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'PostController@index')->name('posts.index');
Route::post('/register', 'RegisterController@create')->name('register.create');
Route::post('/posts/more', 'PostController@more')->name('posts.more');

Route::get('/users/trying/{post}', [PostController::class, 'trying'])->name('posts.trying');
Route::get('/users/complete/{post}', [PostController::class, 'complete'])->name('posts.complete');