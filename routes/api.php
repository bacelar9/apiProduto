<?php

use Illuminate\Http\Request;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/api/category', 'CategoryController@index');
$router->post('/api/category', 'CategoryController@index');


//Route::resource('category', 'CategoryController');
//Route::resource('product', 'ProductController');
//Route::resource('file', 'FileController');