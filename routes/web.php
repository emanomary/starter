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
define('PAGINATION_COUNT',5);
Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', function () {
    return 'You are not allowed';
})->name('dashboard');

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
#############################################################################
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function()
    {
        Route::group(['prefix'=>'offers'],function (){

            Route::get('index','CrudController@index')->name('offers.index');
            Route::get('get-inactive-offer','CrudController@getAllInactiveOffers')->name('offers.inactive');
            Route::get('create','CrudController@create')->name('offers.create');
            Route::post('store','CrudController@store')->name('offers.store');
            Route::get('edit/{id}','CrudController@edit')->name('offers.edit');
            Route::post('update/{id}','CrudController@update')->name('offers.update');
            Route::get('delete/{id}','CrudController@delete')->name('offers.delete');

    });
        Route::get('video','CrudController@getVideo')->middleware('auth')->name('video');

});


############################## Ajax #########################################
Route::group(['prefix'=> 'ajax-offers','namespace' => 'Offer'], function (){

    Route::get('create','OfferController@create')->name('ajaxoffers.create');
    Route::post('store','OfferController@store')->name('ajaxoffers.store');
    Route::get('index','OfferController@index')->name('ajaxoffers.index');
    Route::post('delete','OfferController@delete')->name('ajaxoffers.delete');
    Route::get('edit/{id}','OfferController@edit')->name('ajaxoffers.edit');
    Route::post('update','OfferController@Update')->name('ajaxoffers.update');
});
############################## End Ajax ####################################

############################## Authentication && Guards ####################
Route::group(['namespace' => 'Auth','prefix'=>'customauth','middleware'=>'CheckAge'],function ()
{
    Route::get('index','CustomAuthController@adult')->name('customauth.index');
});
Route::get('site','Auth\CustomAuthController@site')->middleware('auth:web')->name('site');
Route::get('admin','Auth\CustomAuthController@admin')->middleware('auth:admin')->name('admin');

Route::get('admin/login', 'Auth\CustomAuthController@adminLogin')-> name('admin.login');
Route::post('admin/login', 'Auth\CustomAuthController@checkAdminLogin')-> name('save.admin.login');

######################## End Authentication && Guards ######################


/************************** Begin Relations route *********************/

######################## Begin one to one Relations route #########################
Route::group(['namespace'=>'Relation'],function ()
{
    Route::get('has-one','RelationsController@hasOneRelation');
    Route::get('has-one-reverse','RelationsController@hasOneRelationReverse');
    Route::get('get-user-has-phone','RelationsController@getUserHasPhone');
    Route::get('get-user-not-has-phone','RelationsController@getUserNotHasPhone');
    Route::get('get-user-has-phone-with-condition','RelationsController@getUserHasPhoneWithCondition');
});
######################## End One to one Relations route ######################

######################## Begin One to many relations #####################
Route::group(['namespace'=>'Relation'],function ()
{
    Route::get('hospital-has-many','RelationsController@getHospitals');
    Route::get('hospital-has-many-doctors','RelationsController@getHospitalDoctors');

    Route::get('hospitals','RelationsController@hospitals')->name('hospitals');
    Route::get('doctors/{hospital_id}','RelationsController@showDoctors')->name('doctors.show');

    Route::get('hospital-has-doctor','RelationsController@HospitalHasDoctors');
    Route::get('hospital-has-doctor-male','RelationsController@HospitalHasDoctorMale');
    Route::get('hospital-not-has-doctor-male','RelationsController@HospitalNotHasDoctorMale');

    Route::get('hospitals/{hospital_id}','RelationsController@deleteHospital')->name('hospital.delete');
});
######################## End One to many Relations route #################

######################## Begin Many to many relations #####################
Route::group(['namespace'=>'Relation'],function ()
{
    Route::get('doctor/service','RelationsController@getDoctorService');
    Route::get('service/doctor','RelationsController@getServiceDoctor');

    Route::get('doctors/services/{doctor_id}','RelationsController@getDoctorServicesById')->name('doctors.services');
    Route::post('saveServices-to-doctor','RelationsController@saveServicesToDoctors')-> name('save.doctors.services');

});
######################## End Many to many Relations route #################

######################## Begin has one through relations #####################
Route::group(['namespace'=>'Relation'],function ()
{
    Route::get('has-one-through','RelationsController@getPatientDoctor');
    Route::get('has-many-through','RelationsController@getCountrytDoctor');
    Route::get('country/hospital','RelationsController@getCountrytHospital');

});
######################## End has one through Relations route #################
/********************* End Relations route ***************************/
