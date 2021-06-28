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
//     return view('welcome');
// });

// Auth
Route::group(['prefix' => '/'], function () {
    Route::get('/', 'authController@index')->name('auth.index');
    Route::post('/login', 'authController@postLogin')->name('auth.index.post');
    Route::get('/logout', 'authController@logout')->name('auth.logout');
});

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', 'dashboardController@index')->name('dashboard');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'adminController@index')->name('admin.index');
    Route::get('/add', 'adminController@add')->name('admin.add');
    Route::post('/add', 'adminController@save')->name('admin.save');
    Route::get('/edit/{id}', 'adminController@edit')->name('admin.edit');
    Route::patch('/update/{id}', 'adminController@update')->name('admin.update');
    Route::delete('/delete/{id}', 'adminController@edit')->name('admin.delete');
});

Route::group(['prefix' => 'wadir3'], function () {
    Route::get('/', 'wadir3Controller@index')->name('wadir3.index');
    Route::get('/add', 'wadir3Controller@add')->name('wadir3.add');
    Route::post('/add', 'wadir3Controller@save')->name('wadir3.save');
    Route::get('/edit/{id}', 'wadir3Controller@edit')->name('wadir3.edit');
    Route::patch('/update/{id}', 'wadir3Controller@update')->name('wadir3.update');
    Route::delete('/delete/{id}', 'wadir3Controller@edit')->name('wadir3.delete');
});

Route::group(['prefix' => 'kategorievent'], function () {
    Route::get('/', 'kategoriEventController@index')->name('kategorievent.index');
    Route::get('/add', 'kategoriEventController@add')->name('kategorievent.add');
    Route::post('/add', 'kategoriEventController@save')->name('kategorievent.save');
    Route::get('/edit/{id_kategori}', 'kategoriEventController@edit')->name('kategorievent.edit');
    Route::patch('/update/{id_kategori}', 'kategoriEventController@update')->name('kategorievent.update');
    Route::delete('/delete/{id_kategori}', 'kategoriEventController@edit')->name('kategorievent.delete');
});

Route::group(['prefix' => 'ormawa'], function () {
    Route::get('/', 'ormawaController@index')->name('ormawa.index');
    Route::get('/add', 'ormawaController@add')->name('ormawa.add');
    Route::post('/add', 'ormawaController@save')->name('ormawa.save');
    Route::get('/detail/{id_ormawa}', 'ormawaController@detail')->name('ormawa.detail');
    Route::get('/edit/{id_ormawa}', 'ormawaController@edit')->name('ormawa.edit');
    Route::patch('/update/{id_ormawa}', 'ormawaController@update')->name('ormawa.update');
    Route::delete('/delete/{id_ormawa}', 'ormawaController@edit')->name('ormawa.delete');
});
