<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('recipe_app.recipe_app');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/', 'recipeControllers\AppController@index')->name('recipe-app');
Route::post('search-product', 'recipeControllers\AppController@searchProduct')->name('search-product');
Route::get('product-valid', 'recipeControllers\AppController@productValid')->name('product-valid');


