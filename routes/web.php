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

Route::get('redirect/{service}','SocialController@redirect');

Route::get('/callback/{service}','SocialController@callback');

Route::get('/fillable','CrudController@getOffer');

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function()
    {
        Route::group(['prefix'=>'offers'],function (){

            Route::get('index','CrudController@index')->name('offers.index');
            Route::get('create','CrudController@create')->name('offers.create');
            Route::post('store','CrudController@store')->name('offers.store');
            Route::get('edit/{id}','CrudController@edit')->name('offers.edit');
            Route::post('update/{id}','CrudController@update')->name('offers.update');
            Route::get('delete/{id}','CrudController@delete')->name('offers.delete');

    });
        Route::get('video','CrudController@getVideo')->middleware('auth')->name('video');

});


############# Ajax ##################
Route::group(['prefix'=> 'ajax-offers','namespace' => 'Offer'], function (){

    Route::get('create','OfferController@create')->name('ajaxoffers.create');
    Route::post('store','OfferController@store')->name('ajaxoffers.store');
});
