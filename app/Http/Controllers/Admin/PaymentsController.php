<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree\Transaction;
use App\Flat;
use App\Promotion;


class PaymentsController extends Controller
{
  public function show(Request $request){
    $promotion=$request->promotion;
    return view('admin.payments.show', compact('promotion'));
  }


public function process(Request $request)
{
    
    $payload = $request->input('payload', false);
    //$amount = $request->input('amount', false);
    $promotion=$request->promotion;
    $nonce = $payload['nonce'];

    $status = \Braintree\Transaction::sale([
	    'amount' => Promotion::where('id',$promotion)->first()->price,
	    'paymentMethodNonce' => $nonce,
	    'options' => [
	      'submitForSettlement' => True
    	]
    ]);
    
    return response()->json($status);
}
}
