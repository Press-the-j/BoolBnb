<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::get('/flats', 'Api\FlatController@index');
//Route::group(['middleware' => 'auth'], function () {
Route::post('/messages/{id}', 'Api\MessageController@setRead');
//Route::post('/messages/delete/{id}', 'Api\MessageController@delete');
Route::post('/views/{id}/{userId}', 'Api\ViewController@setView');
Route::get('/statistics/weekly/{id}', 'Api\StatisticsController@getData');
Route::get('/statistics/pie/{id}', 'Api\StatisticsController@getDataPie');
//});