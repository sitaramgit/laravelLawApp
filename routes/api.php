<?php

 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('uploadImage', 'API\LawyerController@uploadImage');
Route::post('login', 'API\UsersController@login');
Route::post('register', 'API\UsersController@register');

Route::group(['middleware' => 'auth:api'], function(){
Route::post('details', 'API\UsersController@details');
Route::get('logout', 'API\UsersController@logoutApi');
Route::get('getAllUsers', 'API\UsersController@getAllUsers');

//lawyer
Route::post('saveLawyerProfile', 'API\LawyerController@store');
Route::get('getLawyerProfile/{id}', 'API\LawyerController@getLawyerProfile');
Route::post('updateLawyerProfile/{id}', 'API\LawyerController@update');
Route::get('myClients/{id}', 'API\LawyerController@myClients');


//client
Route::post('saveClientProfile', 'API\ClientController@store');
Route::get('getClientProfile/{id}', 'API\ClientController@getClientProfile');
Route::post('updateClientProfile/{id}', 'API\ClientController@update');
Route::get('getClientDashboard/{id}', 'API\ClientController@getClientDashboard');
//admin


Route::get('getAllClients', 'API\ClientController@getAllClients');
Route::post('updateStatus', 'API\ClientController@updateStatus');
Route::get('getAllLawyerProfiles', 'API\LawyerController@getAllLawyerProfiles');
Route::get('getDashboardDetails', 'API\AdminController@dashboardDetails');


//chat
// Route::post('updateStatus', 'API\ClientController@updateStatus');
Route::apiResource('chat', 'API\ChatController');
// Route::post('chatSave', 'API\ChatController@store'); 
Route::post('getChat', 'API\ChatDataController@showChat');
Route::post('updateStatus', 'API\ChatDataController@updateStatus');

});
