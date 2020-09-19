<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Message;

class MessageController extends Controller
{
    public function setRead($id){
      //http_response_code(500);
      $message=Message::where('id', $id)->first();
      $message->is_read = 1;
      $message->save();

      return response()->json(
        [
          'success' => true,
          'message' => 'Data inserted successfully'
        ]);
    }


    
}
