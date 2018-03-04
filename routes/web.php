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
Route::group(['prefix' => 'doctor'], function () {
    Route::get('register','Auth\RegisterDoctorController@showRegistrationForm')->name('drv');
    Route::post('register','Auth\RegisterDoctorController@register')->name("doctor_register");
    Route::group(['middelware'=>'auth'],function(){
      Route::get('register/patient','Auth\RegisterPatientController@showRegistrationForm');
      Route::post('register/patient','Auth\RegisterPatientController@register')->name("patient_register");
    });
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
