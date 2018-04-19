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

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();
Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('cats', "CategorieController");
    $router->get('api/cat','CategorieController@apiCats');
    $router->get('api/cat/malfunctions','CategorieController@apiMalfunctions');
    $router->get('api/cat/standards','CategorieController@apiStandards');
    $router->get('api/cat/products','CategorieController@apiProducts');



    $router->resource('brands', "BrandController");
    $router->get('api/brand/cats','BrandController@apiCats');



    $router->resource('products', "ProductController");
    $router->get('api/product/malfunctions','ProductController@apiMalfunctions');

    $router->resource('standards', 'StandardController');


    $router->resource('malfunctions', "MalfunctionController");
    $router->get('api/malfunction/resolvents','MalfunctionController@apiResolvents');


    $router->resource('service-types', "ServiceTypeController");


    $router->resource('merchants', "MerchantController");
    $router->resource('test', "ExampleController");

});