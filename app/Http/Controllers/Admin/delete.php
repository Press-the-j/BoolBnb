<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree\Transaction;
use App\Flat;
use App\Promotion;
use Braintree;


class PaymentsController extends Controller
{
  public function make(Flat $flat){
    
    $thisFlat = Flat::where('id', $flat->id)->first();
    $promotions=Promotion::all();

    $gateway = new Braintree\Gateway([
      'environment' => env('BT_ENVIRONMENT'),
      'merchantId' => env('BT_MERCHANT_ID'),
      'publicKey' => env('BT_PUBLIC_KEY'),
      'privateKey' => env('BT_PRIVATE_KEY')
  ]);
    $clientToken=$gateway->ClientToken()->generate(); 
    $data=[
      'promotions'=>$promotions,
      'flat'=>$thisFlat,
      'clientToken'=>$clientToken
    ];
    return view('admin.payments.payment', $data);
  }


public function process(Request $request)
{
    
    $payload = $request->input('payload', false);
    //$amount = $request->input('amount', false);
    $promotion=$request->promotion;
    $nonce = $payload['nonce'];

    $status = Braintree\Transaction::sale([
	    'amount' => Promotion::where('id',$promotion)->first()->price,
	    'paymentMethodNonce' => $nonce,
	    'options' => [
	      'submitForSettlement' => True
    	]
    ]);
    
    return response()->json($status);
}
}
