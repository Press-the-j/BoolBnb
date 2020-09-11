<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\View;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function getData($id){


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

      
      //!da broswer non escono con il giusto ordine verifica che invece siano in ordine
      $viewForDay=array_fill_keys($keysArrView, '');
      foreach($views as $view){
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

      
      return response()->json([
        "success"=> 'si',
        "week"=>$week,
        "keys"=>$keysArrView,
        "StartWeek"=>$viewsDone,
        "counter"=>$countViews,
        "viewForDay"=>$viewForDayArr
      ]);
    }
}
