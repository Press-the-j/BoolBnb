<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Flat;
use App\FlatInfo;
use App\Service;

class FlatController extends Controller
{
  public function index()
  {
    $flats=Flat::all();
    
    $data= [];
    foreach($flats as $flat){
      $arrServices=[];
      $services=$flat->services;
      foreach($services as $service){
        $thisService=$service->slug;
        array_push($arrServices, $thisService);
      }
      $singleFlat=[
        "id"=>$flat->id,
        "title"=>$flat->title,
        "description"=>$flat->flatInfo->description,
        "image_path"=>$flat->flatInfo->image_path,
        "city"=>$flat->flatInfo->city,
        "address"=>$flat->flatInfo->address,
        "postal_code"=>$flat->flatInfo->postal_code,
        "price"=>$flat->flatInfo->price,
        "max_guest"=>$flat->flatInfo->max_guest,
        "rooms"=>$flat->flatInfo->rooms,
        "baths"=>$flat->flatInfo->baths,
        "position"=>$flat->position,
        "services"=>$arrServices,
        "is_hidden"=>$flat->is_hidden,
        "is_promoted"=>$flat->is_promoted,
        
      ];
      array_push($data, $singleFlat);
    }
    return response()->json([
      
      "data"=>$data,
      

    ]);
  }
}
