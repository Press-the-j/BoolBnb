<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Flat;
use App\Promotion;
use Braintree;
use Carbon\Carbon;

class PromotionController extends Controller
{




  public function transaction(Flat $flat)
  {

    $thisFlat = Flat::where('id', $flat->id)->first();
    $promotions = Promotion::all();

    $gateway = makeGateway();

    $clientToken = $gateway->ClientToken()->generate();
    $data = [
      'promotions' => $promotions,
      'flat' => $thisFlat,
      'clientToken' => $clientToken
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




      // $pivot = Flat::find($flat->id)->promotions[$promotion->id]->pivot;
      // $pivot->started_at = $now;
      /* $flat->promotions->pivot->started_at->update($now); */
      $flat->promotions()->updateExistingPivot($flat->id, ['started_at' => $now]);

      $flat->promotions()->sync([$promotion->id]);






      return redirect()->route('admin.flats.show', ['flat' => $flat->id]);
    } else {
      return abort('404');
    }
  }
}