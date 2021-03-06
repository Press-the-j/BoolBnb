<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Flat;
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

Route::get('/', 'FlatController@index')->name('home');
Route::get('/flats/{id}', 'FlatController@show')->name('show');
Route::post('/messages/{flat}', 'MessageController@send')->name('messages.send');

Route::prefix('admin')->namespace('Admin')->name('admin.')->middleware('auth')->group(function () {
  Route::put('/update', 'UserController@update')->name('user.update');
  Route::get('/promotion/{flat}', 'PromotionController@transaction')->name('promotion.transaction');
  Route::post('/promotion/process/{flat}', 'PromotionController@process')->name('promotion.process');
  Route::get('/home', 'HomeController@index')->name('home');
  Route::get('/messages', 'MessageController@index')->name('messages');
  Route::get('/messages/{messageClicked}', 'MessageController@clickMessage')->name('messages.index');
  Route::delete('/messages/delete/{id}', 'MessageController@delete')->name('messages.delete');
  Route::resource('/flats', 'FlatController');
  Route::get('/flat/statistics', 'FlatController@statistics')->name('flats.statistics');
  
});



Auth::routes();

/* Route::get('/home', 'HomeController@index')->name('home'); */

Route::get('/test', function (Request $request) {
  //$user = Auth::user(); //getting the current logged in user
  $flat = Flat::find(1);
  dd($flat->position->getLat());
});

Route::get('/tomtom', function () {
  return view('tomtom');
});

// Route::get('/prova_home', )