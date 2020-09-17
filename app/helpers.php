<?php

use Illuminate\Support\Facades\Auth;
use App\Flat;
 
function control_slug($slug)
{
    // !CONTROLLO CHE NON SI GENERINO 2 SLUG UGUALI
    //devo vedere se nel db c'e' gia uno slug uguale
    $findSlug =Flat::where('slug', $slug)->first();
    $originalSlug = $slug;
    $counter = 0;
    //se c'e' tramite un contatore aggiunto 1 allo slug corrente
    while ($findSlug) {
        $counter++;
        $slug = $originalSlug . '-' . $counter;
        //rifaccio il controllo fino a quando non lo trovo piu
        $findSlug =Flat::where('slug', $slug)->first();
    };
 
    return $slug;
}
 
function update_control_slug($slug, $flat)
{
    // !CONTROLLO CHE NON SI GENERINO 2 SLUG UGUALI
    //devo vedere se nel db c'e' gia uno slug uguale
    $findFlat =Flat::where('id', $flat->id)->first();
    $findSlug=Flat::where('slug', $slug)->first();
    $originalSlug = $slug;
    $newSlug=$slug;
    $counter = 0;
    //se c'e' tramite un contatore aggiunto 1 allo slug corrente
    //!controllo anche che lo slug gia esistente non sia quello del Flat che sto editando
    while ($findSlug && $findSlug->id == $flat->id) {
        $counter++;
        $newSlug = $originalSlug . '-' . $counter;
        //rifaccio il controllo fino a quando non lo trovo piu
        $findSlug =Flat::where('slug', $slug)->first();
    };
 
    return $newSlug;
}


function makeGateway(){
  $gateway = new Braintree\Gateway([
    'environment' => env('BT_ENVIRONMENT'),
    'merchantId' => env('BT_MERCHANT_ID'),
    'publicKey' => env('BT_PUBLIC_KEY'),
    'privateKey' => env('BT_PRIVATE_KEY')
 ]);
 return $gateway;
}


function getIp(){
  foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
      if (array_key_exists($key, $_SERVER) === true){
          foreach (explode(',', $_SERVER[$key]) as $ip){
              $ip = trim($ip); // just to be safe
              if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                  return $ip;
              }
          }
      }
  }
}


function getMessage(){
  $flats=Auth::user()->flats;
  $messageArr=[];
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
  }

  array_push($messageArr, $allMessages, $unreadMessages);

  return $messageArr;

}


