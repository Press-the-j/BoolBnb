<?php

namespace App\Http\Controllers;

use Grimzy\LaravelMysqlSpatial\Types\Point;
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
     
      $views=View::where('flat_id', 1)->get();
      $thisWeek=Carbon::now()->setTime(0, 0, 0)->subDays(6);
      $week=[];
      
      for($i=7; $i>0; $i--){
        array_push($week,Carbon::now()->subDays($i-1)->isoFormat('dddd'));
      }
      
      $viewsDone=[];
      
      $keysArrView=[];
      for($i=0; $i<count($week); $i++){
        array_push($keysArrView, $week[$i]);
      }

      $countViews=count($viewsDone);
      $viewForDay=array_fill_keys($keysArrView, '');
      foreach($views as $view){
        if($view->created_at > $thisWeek){
          array_push($viewsDone, $view);
          $timeStampDay=new Carbon($view->created_at);
          $nameDay=$timeStampDay->isoFormat('dddd');
          $viewForDay[$nameDay]++;
        }
      }
      $viewForDayArr=[];
      foreach($viewForDay as $dailyView){
       if($dailyView != null){
         array_push($viewForDayArr, $dailyView);
       }else{
         array_push($viewForDayArr, 0);
       }
      }
      dd($viewForDayArr);

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
      return view('home', compact('flats', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
      return view('show', compact('flat', 'lat', 'lon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}