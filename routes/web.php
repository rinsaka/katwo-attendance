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
    return view('welcome');
});

// Auth::routes();
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth:user'], function() {
  Route::get('/home', 'HomeController@index')->name('home');
  Route::post('/home/confirm_delete', 'HomeController@confirm_delete');
  Route::get('/home/list', 'HomeController@all_act');
  Route::get('/home/mail', 'HomeController@mail_footer');
  Route::get('/home/{year}/{month}', 'HomeController@show');
  Route::get('/home/{year}/{month}/create', 'HomeController@create');
  Route::get('/home/{year}/{month}/{aid}/edit', 'HomeController@edit');
  Route::post('/home/', 'HomeController@store')->name('store');
  Route::patch('/home/', 'HomeController@update')->name('update');
  Route::delete('/home/', 'HomeController@destroy')->name('destroy');
  Route::get('/menu/create', 'MenusController@create');
  Route::get('/menu/{id}', 'MenusController@show');
  Route::get('/menu/{id}/mail', 'MenusController@mail');
  Route::patch('/menu', 'MenusController@update')->name('menu_update');
  Route::post('/menu', 'MenusController@store')->name('menu_store');

});


// Admin 認証不要
Route::group(['prefix' => 'admin'], function() {
  Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
  Route::post('login', 'Admin\LoginController@login');
});

// Admin ログイン後
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
  Route::get('home', 'Admin\HomeController@index')->name('admin.home');
  Route::get('activity/create', 'Admin\HomeController@create');
  Route::get('activity/{aid}', 'Admin\HomeController@edit')->name('admin.home');
  Route::patch('activity', 'Admin\HomeController@update')->name('admin_act_update');
  Route::post('activity', 'Admin\HomeController@store')->name('admin_act_store');
  Route::post('logout', 'Admin\LoginController@logout')->name('admin.logout');
  Route::delete('activity/{id}', 'Admin\HomeController@destory');
  Route::get('place', 'Admin\HomeController@place')->name('admin.place');
  Route::get('place/create', 'Admin\HomeController@place_create');
  Route::get('place/{pid}', 'Admin\HomeController@place_edit');
  Route::delete('place/{pid}', 'Admin\HomeController@place_destroy');
  Route::get('place/{pid}/delete', 'Admin\HomeController@place_delete');
  Route::patch('place', 'Admin\HomeController@place_update')->name('admin_place_update');
  Route::post('place', 'Admin\HomeController@place_store')->name('admin_place_store');
  Route::get('time', 'Admin\HomeController@time')->name('admin.time');
  Route::get('time/create', 'Admin\HomeController@time_create');
  Route::get('time/{tid}', 'Admin\HomeController@time_edit')->name('admin.time_edit');
  Route::get('time/{tid}/delete', 'Admin\HomeController@time_delete');
  Route::patch('time', 'Admin\HomeController@time_update')->name('admin_time_update');
  Route::post('time', 'Admin\HomeController@time_store')->name('admin_time_store');
  Route::delete('time/{tid}', 'Admin\HomeController@time_destroy');
  Route::get('password', 'Admin\HomeController@passwd');
  Route::patch('password', 'Admin\HomeController@passwd_update')->name('admin.passwd');
  Route::get('userpassword', 'Admin\HomeController@userpasswd');
  Route::patch('userpassword', 'Admin\HomeController@userpasswd_update')->name('admin.userpasswd');
  Route::get('mailinfo', 'Admin\MailinfosController@edit');
  Route::post('mailinfo', 'Admin\MailinfosController@update')->name('admin.mailinfo');
});
