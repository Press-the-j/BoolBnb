<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
  public function index()
  {

  /* $flats=Auth::user()->flats;
  $allMessages=[];
  $unreadMessages=[];
  $count=0;

  $unreadMessages['exist']=false;

  foreach($flats as $flat){
    $messages=$flat->messages;
    foreach($messages as $message){

      //? se il messaggio non è letto aggiorniamo il count
      if($message->is_read == 0){
        $count++;
      }
      
      array_push($allMessages, [
        "id"=>$message->id,
        "email"=>$message->email_sender,
        "content"=>$message->content,
        "is_read"=>$message->is_read,
        "flat_id"=>$flat->id
        ]);
    }
  }

  //? se il count è diverso da 0, allora aggiorniamo la variabile unreadMessage
  if($count !== 0){
    $unreadMessages['exist']= true;
    $unreadMessages['count']= $count;
  } */


  $messageArr=getMessage();
  $allMessages=$messageArr[0];
  $unreadMessages=$messageArr[1];
  $data=[
    'allMessages'=>$allMessages,
    'unreadMessages'=>$unreadMessages
  ];
  
  
  return view('admin.home', $data);
  }
}
