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

Route::get('/', 'Main\HomeController@index');



//DashBoard ===================================================
Route::get('dashboard', 'DashBoard\MainController@index');

Route::get('dashboard/login', 'DashBoard\LoginController@index');
Route::post('dashboard/login', 'DashBoard\LoginController@postLogin');

Route::get('dashboard/register', 'DashBoard\MainController@getRegister');
Route::post('dashboard/register', 'DashBoard\MainController@postRegister');
Route::get('dashboard/logout', 'DashBoard\MainController@getLogout');

//setting
Route::resource('dashboard/settings', 'DashBoard\SettingController');

//Item
Route::resource('dashboard/items', 'DashBoard\ItemController');

//Category
Route::resource('dashboard/categories', 'DashBoard\CategoryController');

//Category
Route::resource('dashboard/tags', 'DashBoard\TagController');

//Fix
Route::resource('dashboard/fixes', 'DashBoard\FixController');


//Main =========================================================
//Fix Page
if(Schema::hasTable('fixes')) {
    use App\Fix;
    $fixes = Fix::where('open_status', 1)->get();
    foreach($fixes as $fix) {
        Route::get($fix->slug, 'Main\HomeController@getFix');
    }
}

//Single
Route::get('/item/{id}', 'Main\SingleController@index');
Route::post('/cart', 'Main\SingleController@postCart');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
