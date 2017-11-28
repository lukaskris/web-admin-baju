<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware'    => ['web', 'admin'],
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->get('/api/subitem','RestockController@subitem');
    $router->get('/api/item','RestockController@item');
	$router->resource('category', CategoryController::class);
	$router->resource('item', ItemController::class);
	$router->resource('customer', CustomerController::class);
	$router->resource('orders', OrdersController::class);
	$router->resource('restock', RestockController::class);
});
