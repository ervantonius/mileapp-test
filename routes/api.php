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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('package')->group(function() {
	Route::get('', 'PackageController@list')->name('package.list');
	Route::get('{id}', 'PackageController@detail')->name('package.detail');
	Route::post('', 'PackageController@store')->name('package.store');
	Route::put('{id}', 'PackageController@put')->name('package.put');
	Route::patch('{id}', 'PackageController@patch')->name('package.patch');
	Route::delete('{id}', 'PackageController@destroy')->name('package.destroy');
});
