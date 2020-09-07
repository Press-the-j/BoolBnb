<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Flat;
use Braintree;

class PaymentController extends Controller
{
    public function makeGateway(Flat $flat){
      $gateway = new \Braintree\Gateway ([
        'environment' => 'sandbox',
        'merchantId' => env('BT_MERCHANT_ID'),
        'publicKey' => env('BT_PUBLIC_KEY'),
        'privateKey' => env('BT_PRIVATE_KEY')
    ]);
    $clientToken = $gateway->clientToken()->generate();
    $data= [
      //'gateway'=>$gateway,
      'clientToken'=>$clientToken
    ]; 
      return view('admin.payments.payments', $data );
    }

    public function makePayment(Request $request){
      dd($request);
      $payload=$request->input("payload", false);
      $nonce= $payload['nonce'];
      $status= Braintree\Transaction::sale([
        "amount"=>10,
        "paymentMethodNonce"=>$nonce,
        "options"=>[
          "submitForSettlement"=>True
        ]
      ]);

    }
    
}
