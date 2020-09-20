<?php

namespace App\Http\Controllers;

use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Flat;
use App\Service;
use Carbon\Carbon;
use App\View;

class FlatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $flat=Flat::where('id', 1)->first();
      $createdAt=new Carbon( $flat->created_at);
      $createdAtmid=$createdAt->setTime(0,0,0) ;
      $now=Carbon::now()->setTime(0,0,0);
      $timeCreate=($now->diffInDays($createdAt)) + 1;
      
      /* if($countViews){
        $mediaViews= $countViews / $timeCreate;

      } */
      
      $promotions=$flat->promotions;
      $counterViewsProm=0;
      $counterTimeProm=0;

     
      if(count($promotions) != 0){
        foreach($promotions as $promotion){
          $createdAtProm=new Carbon($promotion->pivot->started_at);
          $createdAtPromMid=$createdAtProm->setTime(0,0,0);
          $timePromoted=($now->diffInDays($createdAtPromMid)) + 1;
          $counterTimeProm= $counterTimeProm + $timePromoted;
          $counterViewsProm =$counterViewsProm +  $timePromoted;
        }
        $mediaPromViews=$counterViewsProm / $counterTimeProm ;
      }
      

    $flats=Flat::where('is_promoted', 1)->get();
    $services=Service::all();
    $now=Carbon::now();
    foreach($flats as $flat){
      foreach($flat->promotions as $promotion){
        $end_at=$promotion->pivot->end_at;
        $end_atCarbon=new Carbon($end_at);
        if($now->greaterThan($end_at)){
          $flat->is_promoted=0;
          $flat->save();
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
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      
    //dd($id);
    $flat=Flat::where('id',$id)->first();
    
    $lat=$flat->position->getLat();
    $lon=$flat->position->getLng();


    $allMessages='';
    $unreadMessages='';
    if(Auth::check()){
      $messageArr=getMessage();
      $allMessages=$messageArr[0];
      $unreadMessages=$messageArr[1];
    }
  
    return view('show', compact('flat', 'lat', 'lon', 'allMessages', 'unreadMessages' ));
    }

}