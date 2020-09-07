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


Route::prefix('admin')->namespace('Admin')->name('admin.')->middleware('auth')->group(function () {
  Route::get('/payment/{id}', 'PaymentController@makeGateway')->name('payment');
  Route::get('/payment/make', 'PaymentController@makePayment')->name('payment.make');
  Route::get('/home', 'HomeController@index')->name('home');
  Route::resource('/flats', 'FlatController');
});



Auth::routes();

/* Route::get('/home', 'HomeController@index')->name('home'); */

Route::get('/test', function (Request $request) {
  //$user = Auth::user(); //getting the current logged in user
  $flat = Flat::find(1);
  dd($flat->position->getLat());
  //dd($user->hasRole('dev')); // and so on
  //dd($user->can('suck'));
});

Route::get('/tomtom', function () {
  return view('tomtom');
});

// Route::get('/prova_home', )