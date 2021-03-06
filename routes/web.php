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
Route::get('/', 'HomeController@index')->name('home');

Route::get('/search', 'HomeController@search')->name('search');

Route::get('/group/{slug}', 'HomeController@group')->name('group');
Route::get('/product/{slug}', 'HomeController@product')->name('product');

Route::get('/cart', 'HomeController@cart')->name('cart');
Route::post('/cart', 'HomeController@cartAdd')->name('cart.add');
Route::post('/cart/delete', 'HomeController@cartDelete')->name('cart.delete');

Route::get('/page/{slug}', 'HomeController@page');