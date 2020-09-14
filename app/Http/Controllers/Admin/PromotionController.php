<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Flat;
use App\Promotion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Braintree;

class PromotionController extends Controller
{




  public function transaction(Flat $flat)
  {

    $thisFlat = Flat::where('id', $flat->id)->first();
    $promotions = Promotion::all();

    $gateway = makeGateway();

    $clientToken = $gateway->ClientToken()->generate();

    $messageArr=getMessage();
    $allMessages=$messageArr[0];
    $unreadMessages=$messageArr[1];
    
    $data = [
      'promotions' => $promotions,
      'flat' => $thisFlat,
      'clientToken' => $clientToken,
      'allMessages'=>$allMessages,
      'unreadMessages'=>$unreadMessages
    ];
    return view('admin.transaction.payment', $data);
  }

  public function process(Flat $flat, Request $request)
  {
    $payload = $request->payment_method_nonce;
    //$amount = $request->input('amount', false);
    $promotion = Promotion::where('id', $request->promotion)->first();
    $flat = Flat::where('id', $flat->id)->first();
    $amount = $promotion->price;

    $gateway = makeGateway();

    $status = $gateway->transaction()->sale([
      'amount' => $amount,
      'paymentMethodNonce' => $payload,
      'options' => [
        'submitForSettlement' => True
      ]
    ]);

    if ($status->success || !is_null($status->transaction)) {
      
      $flat->is_promoted = 1;
      $flat->save();
      $now = Carbon::now();

      //Sincronizziamo fla e promotion
      $flat->promotions()->sync([$promotion->id]);
      
      //aggiungiamo la data di partenza della promotion
      $pivotTable=DB::table('flat_promotion')->where("flat_promotion.flat_id", "=", $flat->id)->update(["flat_promotion.started_at"=>$now]);

      //aggiungiamo la data di scadenza della promotion
      $endPromotion=$now->addDays($promotion->duration);
      $pivotTable=DB::table('flat_promotion')->where("flat_promotion.flat_id", "=", $flat->id)->update(["flat_promotion.end_at"=>$endPromotion]);
    

      return redirect()->route('admin.flats.show', ['flat' => $flat->id]);
    } else {
      return abort('404');
    }
  }
}