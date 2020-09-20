<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\View;
use Carbon\Carbon;
use App\Flat;

class StatisticsController extends Controller
{
    public function getData($id){

      $flat=Flat::where('id', $id)->first();
      $views=View::where('flat_id', $id)->get();
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

      $counterViewPromoted=0;
      //!da broswer non escono con il giusto ordine verifica che invece siano in ordine
      $viewForDay=array_fill_keys($keysArrView, '');
      foreach($views as $view){
        if($view->view_promoted==1){
          $counterViewPromoted=$counterViewPromoted + 1;
        }
        if($view->created_at > $thisWeek){
          array_push($viewsDone, $view);
          $nameDay=new Carbon($view->created_at);
          $timeStampDay=new Carbon($view->created_at);
          $nameDay=$timeStampDay->isoFormat('dddd');
          $viewForDay[$nameDay]++;

        }
      }
      $countViews=count($viewsDone);
      
      $viewForDayArr=[];
      foreach($viewForDay as $dailyView){
       if($dailyView != null){
         array_push($viewForDayArr, $dailyView);
       }else{
         array_push($viewForDayArr, 0);
       }
      }
      
      $flat=Flat::where('id', $id)->first();
      $createdAt=new Carbon( $flat->created_at);
      $createdAtmid=$createdAt->setTime(0,0,0) ;
      $now=Carbon::now()->setTime(0,0,0);
      $timeCreate=($now->diffInDays($createdAt)) + 1;
      
      
      $mediaViews= $countViews / $timeCreate;
      
      
      $promotions=$flat->promotions;
      $counterViewsProm=0;
      $counterTimeProm=0;
      $mediaPromViews=0;

      if(count($promotions) != 0){
        foreach($promotions as $promotion){
          $createdAtProm=new Carbon($promotion->pivot->started_at);
          $createdAtPromMid=$createdAtProm->setTime(0,0,0);
          $timePromoted=($now->diffInDays($createdAtPromMid)) + 1;
          $counterTimeProm= $counterTimeProm + $timePromoted;
          
        }
        $mediaPromViews=$counterViewPromoted / $counterTimeProm ;
      }
      

      
      return response()->json([
        "success"=> 'si',
        "week"=>$week,
        "keys"=>$keysArrView,
        "StartWeek"=>$viewsDone,
        "counter"=>$countViews,
        "viewForDay"=>$viewForDayArr,
        "mediaViews"=>number_format((float)$mediaViews, 2,'.', ''),
        "timeCreation"=>$timeCreate,
        "counterProm"=>$counterTimeProm,
        "mediaPromViews"=>$mediaPromViews,
  
      ]);
    }

    public function getDataPie($id)
    {
      $flats=Flat::where('user_id', $id)->get();

      $viewsArr=[];
      $flatsTitleArr=[];

      for($i=0; $i<count($flats); $i++){
        $viewsForFlat=View::where('flat_id', $flats[$i]->id)->get();
        $totalViews=count($viewsForFlat);

        array_push($flatsTitleArr, $flats[$i]->title);
        array_push($viewsArr, $totalViews);
      }

      return response()->json([
        "success"=> 'si',
        "flats_titles"=>$flatsTitleArr,
        "flats_views"=>$viewsArr
      ]);
    }
}
