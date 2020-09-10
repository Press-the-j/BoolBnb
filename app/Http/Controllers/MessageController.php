<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Flat;
use App\Message;

class MessageController extends Controller
{
    public function send(Request $request, Flat $flat){
    
      //TODO Ricordati di validare i campi degli inputt

      $data=$request->all();
      $email=$data['email'];
      $content=$data['message-content'];
      $id=$flat->id;
      $dataMessage=[
        "flat_id"=>$id,
        "email_sender"=>$email,
        "content"=>$content
      ];

      $message=new Message();
      $message->fill($dataMessage);
      $message->save();

      
      
      return redirect()->back()->with('message-success','Messaggio inviato!');
    }

    
}
