<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Flat;
use App\Message;

class MessageController extends Controller
{
  public function index(Message $message){
  
  dd($message->id);
  $flats=Auth::user()->flats;
  $allMessages=[];

  
  
  foreach($flats as $flat){
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
  }
  
  return view('admin.messages.index', compact('allMessages'));
  }
}
