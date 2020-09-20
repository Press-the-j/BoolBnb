<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Flat;
use App\Service;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   /*  public function index()
    {

    $flats=Flat::where('is_promoted', 1)->get();
    $services=Service::all();

    dd($flats);
    $now=Carbon::now();
    foreach($flats as $flat){
      foreach($flat->promotions as $promotion){
        $end_at=$promotion->pivot->end_at;
        if($now>$end_at){
          $flat->is_promoted=0;
          $flat->promotions()->sync([]);
        }
      }
    }

    $allMessages='';
    $unreadMessages='';

    if(Auth::check()){
      $messageArr=getMessage();
      $allMessages=$messageArr[0];
      $unreadMessages=$messageArr[1];
    }

    return view('home', compact('flats', 'services', 'allMessages', 'unreadMessages'));
    } */

    
}
