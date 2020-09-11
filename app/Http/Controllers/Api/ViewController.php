<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Flat;
use App\User;
use App\View;

class ViewController extends Controller
{
    public function setView($id,$userId){
      //$user =$request->user()->id;
      $userIdNum= intval($userId);
      $flat=Flat::where('id', $id)->first();
      //$ip = getIp();

      if($flat->user_id != $userId || $userId=='guest'){
        $view=new View();
        $data=[
          'flat_id'=>$flat->id,
          'view_promoted'=>$flat->is_promoted,
          'ip_user'=>'ciao'
        ];
        $view->fill($data);
        $view->save();

      }

      return response()->json(
        [
          'userId'=>$userIdNum,
          'is_promoted'=>$flat->user_id,
          'flat'=>$flat->id,
          'success' => true,
          'message' => 'Data inserted successfully'
        ]);

    }


}
