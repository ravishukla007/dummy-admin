<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::namespace('Admin')->prefix('admin')->as('admin.')->group(function() {
   	Auth::routes(['register' => false]);
  	Route::middleware('adminauth:admin')->group(function() {
   		Route::get('/', 'HomeController@index');
   		Route::get('/home', 'HomeController@index')->name('home');
   		Route::resource('/category', 'CategoryController');
   		Route::resource('content', 'ContentController', ['only' => ['index', 'edit', 'update']]);
      Route::resource('/post', 'PostController');
      Route::resource('school', 'SchoolController');
   		Route::resource('user', 'UserController');
   		Route::get('profile', 'ProfileController@index')->name('profile');
   		Route::post('profile', 'ProfileController@update');
   		Route::get('change-password', 'ProfileController@changePassword')->name('changepassword');
   		Route::post('change-password', 'ProfileController@updatePassword');
   	});
});
