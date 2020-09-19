<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Flat;
use App\Message;

class MessageController extends Controller
{
  public function index(){
  
    $messageArr=getMessage();
    $allMessages=$messageArr[0];
    $unreadMessages=$messageArr[1];
    $idClicked='';
    
    return view('admin.messages.index', compact('allMessages', 'unreadMessages', 'idClicked'));
  }


  public function clickMessage(Message $messageClicked){
    $flats=Auth::user()->flats;
  //$allMessages=[];
  $idClicked=$messageClicked->id;
  
  
 /*  foreach($flats as $flat){
    $messages=$flat->messages;
    foreach($messages as $message){
      
      array_push($allMessages, [
        "id"=>$message->id,
        "email"=>$message->email_sender,
        "content"=>$message->content,
        "is_read"=>$message->is_read,
        "flat_id"=>$flat->id
        ]);
    }
  } */
  
  $messageRead=Message::where('id', $idClicked)->first();
  $messageRead->is_read = 1;
  $messageRead->save(); 

  $messageArr=getMessage();
  $allMessages=$messageArr[0];
  $unreadMessages=$messageArr[1];

  
  
  
  return view('admin.messages.index', compact('allMessages', 'idClicked', 'unreadMessages'));
  }

  public function delete($id) {
    $message=Message::where('id', $id)->first();

    $message->delete();

    return redirect()->route('admin.messages');

  }

}
