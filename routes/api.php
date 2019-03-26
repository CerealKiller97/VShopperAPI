<?php

// Routes require passport token
Route::group(['middleware' => ['auth:api']], function () {
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
    // Route for changing account password
    Route::patch('/accounts', 'AccountsController@changePasswrod');

    // Routes for handling product images upload / delete
    Route::post('/products/{id}/images', 'ProductImagesController@add');
    Route::delete('/products/{id}/images', 'ProductImagesController@delete');

    // Routes for handling product images upload / delete
    Route::post('/storages/{id}/images', 'StorageImagesController@add');
    Route::delete('/storages/{id}/images', 'StorageImagesController@delete');

    // Routes for adding products to storage
    Route::post('/storages/{id}/products', 'ProductStoragesController@add');
    Route::delete('/storages/{id}/products', 'ProductStoragesController@delete');

    // Routes for handling prices adding prices / updating prices
    Route::post('/prices/products/{id}', 'ProductPricesController@add');
    Route::put('/prices/products/{id}', 'ProductPricesController@update');

    Route::post('/discounts/products/{id}', 'DiscountsController@add');
    Route::put('/discounts/products/{id}', 'DiscountsController@update');

    // Logout route
    Route::post('/logout', 'AuthController@logout');
});

// Non auth routes
Route::post('/login', 'AuthController@login');
Route::post('/register', 'AccountsController@store');

// Route for handling account verification
Route::get('/verification/{token}', 'VerificationController');
