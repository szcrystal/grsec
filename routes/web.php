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
Route::delete('dashboard/register/{id}', 'DashBoard\MainController@destroy');
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
Route::post('dashboard/items/script', 'DashBoard\ItemController@postScript');
Route::resource('dashboard/items', 'DashBoard\ItemController');

//Category
Route::resource('dashboard/categories/sub', 'DashBoard\CategorySecondController');
Route::resource('dashboard/categories', 'DashBoard\CategoryController');


//Tag
Route::resource('dashboard/tags', 'DashBoard\TagController');

//Contact
Route::resource('dashboard/contacts', 'DashBoard\ContactController');

//Sale
Route::resource('dashboard/sales', 'DashBoard\SaleController');

//User
Route::resource('dashboard/users', 'DashBoard\UserController');

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
Route::post('/item/script', 'Main\SingleController@postScript');

//Shop Cart
Route::post('/cart/form', 'Main\SingleController@postForm');
Route::post('/cart/payment', 'Main\SingleController@postCart');
Route::get('/cart/thankyou', 'Main\SingleController@endCart');


Route::post('/shop/cart', 'Cart\CartController@postCart');
Route::get('/shop/cart', 'Cart\CartController@postCart');

Route::post('/shop/form', 'Cart\CartController@postForm');
Route::get('/shop/form', 'Cart\CartController@postForm');

Route::post('/shop/confirm', 'Cart\CartController@postConfirm');
Route::get('/shop/confirm', 'Cart\CartController@postConfirm');

Route::post('/shop/thankyou', 'Cart\CartController@getThankyou');
Route::get('/shop/thankyou', 'Cart\CartController@getThankyou');

Route::get('/shop/clear', 'Cart\CartController@getClear');

//Route::resource('/shop/cart', 'Cart\CartController');

//MyPage
Route::get('/mypage', 'MyPage\MyPageController@index');

Route::get('/mypage/history', 'MyPage\MyPageController@history');
Route::get('/mypage/history/{id}', 'MyPage\MyPageController@showHistory');

Route::get('/mypage/register', 'MyPage\MyPageController@getRegister');
Route::post('/mypage/register', 'MyPage\MyPageController@postRegister');
Route::post('/mypage/register/end', 'MyPage\MyPageController@registerEnd');

Route::get('/mypage/favorite', 'MyPage\MyPageController@favorite');

Route::get('/mypage/optout', 'MyPage\MyPageController@getOptout');
Route::post('/mypage/optout', 'MyPage\MyPageController@postOptout');

//Route::get('logout', 'Auth\LoginController@getLogout');

Auth::routes();
Route::get('/register', 'MyPage\MyPageController@getRegister');
Route::post('/register', 'MyPage\MyPageController@postRegister');
Route::post('/register/end', 'MyPage\MyPageController@registerEnd');


Route::get('/home', 'HomeController@index')->name('home');
