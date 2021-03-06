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

Route::get('/', 'AppointmentsController@index');
Route::get('/get_csv/', 'AppointmentsController@get_csv');
Route::get('/get_pdf/', 'AppointmentsController@get_pdf');
Route::get('/create/', 'AppointmentsController@create');
Route::get('/get_people/{company_id}', 'AppointmentsController@get_people');
Route::post('/store/', 'AppointmentsController@store');
Route::post('/store/{id}', 'AppointmentsController@store');
Route::get('/get_appoinpent_list/', 'AppointmentsController@get_appoinpent_list');
Route::get('/set_status/', 'AppointmentsController@set_status');
Route::get('/delete/', 'AppointmentsController@delete');
Route::get('/update/{id}', 'AppointmentsController@update');