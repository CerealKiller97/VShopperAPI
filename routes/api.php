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

Route::middleware('auth:api')->get('/me', function (Request $request) {
    return $request->user();
});

// Routes require passport token
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/me', 'AccountsController@index');
    Route::apiResources([
        'accounts'      => 'AccountsController',
        'products'      => 'ProductsController',
        'categories'    => 'CategoriesController',
        'brands'        => 'BrandsController',
        'vendors'       => 'VendorsController',
        'storage-types' => 'StorageTypesController',
        'units'         => 'UnitsController'
    ]);
    Route::post('/logout', 'AuthController@logout');
});

// Non auth routes
Route::post('/login', 'AuthController@login');
Route::post('/register', 'AccountsController@store');
