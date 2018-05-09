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

//Consignor
Route::resource('dashboard/consignors', 'DashBoard\ConsignorController');

//MailTemplate
Route::resource('dashboard/mails', 'DashBoard\MailTemplateController');

//DeliveryGroup
Route::resource('dashboard/dgs', 'DashBoard\DeliveryGroupController');
Route::get('dashboard/dgs/fee/{dgId}', 'DashBoard\DeliveryGroupController@getFee');
Route::post('dashboard/dgs/fee/{dgId}', 'DashBoard\DeliveryGroupController@postFee');

//Prefecture
//Route::resource('dashboard/prefectures', 'DashBoard\PrefectureController');

//Item
Route::resource('dashboard/items', 'DashBoard\ItemController');

//Category
Route::resource('dashboard/categories', 'DashBoard\CategoryController');

//Tag
Route::resource('dashboard/tags', 'DashBoard\TagController');

//Contact
Route::resource('dashboard/contacts', 'DashBoard\ContactController');

//Fix
Route::resource('dashboard/fixes', 'DashBoard\FixController');


//Main =========================================================
//Fix Page
if(Schema::hasTable('fixes')) {
    //use App\Fix;
    $fixes = DB::table('fixes')->where('open_status', 1)->get();
    foreach($fixes as $fix) {
        Route::get($fix->slug, 'Main\HomeController@getFix');
    }
}

//Contact
Route::resource('contact', 'Main\ContactController');

//Single
Route::get('/item/{id}', 'Main\SingleController@index');

//Cart
Route::post('/cart/form', 'Main\SingleController@postForm');
Route::post('/cart/payment', 'Main\SingleController@postCart');
Route::get('/cart/thankyou', 'Main\SingleController@endCart');



//Route::get('logout', 'Auth\LoginController@getLogout');
Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
