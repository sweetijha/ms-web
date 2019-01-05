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

Route::get('/test', function () {
    echo 'asdf';
});


Route::post("get_order","OrderController@get_order");
Route::post("add_order","OrderController@add_order");
Route::post("update_status","OrderController@update_status");
Route::post("signup","UserController@signup");
Route::post("get_otp","UserController@get_otp");
Route::post("verify_otp","UserController@verify_otp");
Route::post("login","UserController@login");
Route::post("change_password","UserController@change_password");

Route::post("update_profile","UserController@update_profile");//by ashish
Route::post("createCode","UserController@createCode");//by ashish
Route::post("admin_login","UserController@admin_login");//by ashish
Route::post("change_admin_password","UserController@change_admin_password");//by ashish
Route::post("customer_login_by_admin","UserController@customer_login_by_admin");//by ashish
Route::post("send_unique_code_by_mail","OrderController@send_unique_code_by_mail");//by ashish
Route::post("alternate_login","UserController@alternate_login");//by ashish

Route::get("check_date_time","OrderController@check_date_time");
Route::post("send_mail","OrderController@send_mail");
Route::post("send_sms","OrderController@send_sms");
Route::post("send_reminder_message","OrderController@send_reminder_message");

Route::get("md5convert","OrderController@md5convert");
