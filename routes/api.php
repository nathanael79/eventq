<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//API Register
Route::post('/register','API\ApiRegisterController@create');
//Route::delete('/delete/{id}','API\ApiRegisterController@delete');

//API Login
Route::post('/login','API\ApiLoginController@login');

//API Profile
Route::get('/regencies_id','API\ApiProfileController@getRegenciesId');
Route::get('/detailuser/{id}','API\ApiProfileController@detailuser');
Route::post('/update/{id}','API\ApiProfileController@update');
Route::post('/updatePass/{id}','API\ApiProfileController@updatePassword');


//API Event
Route::post('/register_event','API\ApiEventController@create');
Route::get('/show_event','API\ApiEventController@show');
Route::post('/update_event/{id}','API\ApiEventController@update');
Route::delete('/delete_event/{id}','API\ApiEventController@delete');

//API Search
Route::get('/search','API\ApiEventController@search');

//API test
//Route::get('/account','Database\Account\AccountController@json');
//Route::get('/event','Database\Event\EventController@getDataTable');
Route::post('/get_quota','API\ApiEventParticipantController@getQuota');

//API Event Participant
Route::post('/create_eventpart','API\ApiEventParticipantController@register');
Route::get('/show_eventpart','API\ApiEventParticipantController@show');
Route::get('/show_eventpart/{id}','API\ApiEventParticipantController@showById');

//API Event Filter
Route::get('/show_latest_event','API\ApiFilterEventController@latest_event');
Route::get('/show_done_event','API\ApiFilterEventController@done_event');
Route::get('/show_event_byuser/{id}','API\ApiFilterEventController@event_byUser');

