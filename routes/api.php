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

Route::middleware('auth:api')->get('/member', function (Request $request) {
	return $request->member();
});

Route::post('login', 'LoginController@login');
Route::post('member', 'MemberController@store');
Route::post('admin', 'MemberController@adminStore');

Route::middleware('auth:api')->get('member', 'MemberController@index');
Route::middleware('auth:api')->put('member', 'MemberController@update');
Route::middleware('auth:api')->delete('member/{members}', 'MemberController@destroy');
Route::middleware('auth:api')->get('logout', 'LogoutController@logout');
