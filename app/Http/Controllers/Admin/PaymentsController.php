<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree\Transaction;

class PaymentsController extends Controller
{
  public function show(){
    return view('admin.payments.show');
  }


public function process(Request $request)
{
    $payload = $request->input('payload', false);
    $nonce = $payload['nonce'];

    $status = \Braintree\Transaction::sale([
	'amount' => '10.00',
	'paymentMethodNonce' => $nonce,
	'options' => [
	    'submitForSettlement' => True
	]
    ]);

    return response()->json($status);
}
}
