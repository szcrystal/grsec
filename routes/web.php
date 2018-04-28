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

Route::get('/', function () {
    //return view('welcome');
    echo "";
});


//DashBoard
Route::get('dashboard', 'DashBoard\MainController@index');

Route::get('dashboard/login', 'DashBoard\LoginController@index');
Route::post('dashboard/login', 'DashBoard\LoginController@postLogin');

Route::get('dashboard/register', 'DashBoard\MainController@getRegister');
Route::post('dashboard/register', 'DashBoard\MainController@postRegister');
Route::get('dashboard/logout', 'DashBoard\MainController@getLogout');

//setting
Route::resource('dashboard/settings', 'DashBoard\SettingController');

//Item
Route::resource('dashboard/items', 'dashboard\ItemController');

//Category
Route::resource('dashboard/categories', 'dashboard\CategoryController');

//Category
Route::resource('dashboard/tags', 'dashboard\TagController');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
