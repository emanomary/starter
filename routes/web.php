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

Route::get('/test1', function () {
    return 'welcome';
})->name('a');

Route::get('/test2/{id}', function ($id) {
    return $id;
})->name('b');

Route::get('/test3/{id?}', function () {
    return 'Hello';
})->name('c');

Route::namespace('Front')->group(function (){

   Route::get('users','UserController@showUserName');

});

Route::prefix('users')->group(function(){

    Route::get('/',function (){
        return 'work';
    });

});


Route::group(['prefix' => 'users'], function (){

    Route::get('/',function (){
        return 'work';
    });

});

Route::group(['namespace' => 'Front'],function (){

    Route::get('users1','UserController@showUserName')->middleware('auth');
    Route::get('users2','UserController@showUserName2');

});

Route::get('login',function (){
   return 'You must be login';
})->name('login');

Route::resource('landing','NewsController');

/*Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');*/

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');


