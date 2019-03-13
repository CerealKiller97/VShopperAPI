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

// Routes require passport token
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/me', 'AccountsController@index');
    Route::apiResources([
        'accounts'      => 'AccountsController',
        'products'      => 'ProductsController',
        'categories'    => 'CategoriesController',
        'brands'        => 'BrandsController',
        'groups'        => 'GroupsController',
        'vendors'       => 'VendorsController',
        'storage-types' => 'StorageTypesController',
        'storages'      => 'StoragesController',
        'units'         => 'UnitsController',
        'product-types' => 'ProductTypesController'
    ]);
    Route::post('/logout', 'AuthController@logout');
});

// Non auth routes
Route::post('/login', 'AuthController@login');
Route::post('/register', 'AccountsController@store');
