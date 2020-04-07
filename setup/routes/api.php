<?php

use Illuminate\Http\Request;

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



Route::prefix('v1')->namespace('Api')->group(function() {

	Route::middleware('auth:api')->get('/user', function (Request $request) {
	    return $request->user();
	});

	
	Route::get('baseUrl', 'AuthController@baseUrl');	
	Route::post('send-otp', 'AuthController@sendOtp');
	Route::post('verify-mobile-and-login', 'AuthController@verifyAndLogin');
	Route::post('login', 'AuthController@login');
	Route::post('register', 'AuthController@register');
	
	Route::middleware('auth:api')->group(function() {	
		Route::prefix('profile')->group(function() {	
			Route::post('/', 'ProfileController@update');
			Route::post('change-password', 'ProfileController@changePassword');
		});
	});

	// Send password reset email or otp
	Route::post('password/forgot', 'ForgotPasswordController@forgot');

	Route::post('reset-password', 'AuthController@resetPassword');
	Route::get('content', 'ContentController@get');
	Route::get('category', 'CategoryController@index');
	Route::get('post', 'PostController@index');
	Route::get('school', 'SchoolController@index');

});
