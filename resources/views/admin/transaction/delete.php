@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
    <form method="post" id="payment-form" action="{{route('admin.payment.process'), ['flat'=>$flat->id]}}">
      @csrf
        <section>
            <div class="form-group">
              
              <select name="amount" id="amount-promotion">
                <option value="0">Scegli un piano: </option>
                @foreach ($promotions as $promotion)
                  <option value="{{$promotion->id}}">{{$promotion->price}} &euro;</option>
                @endforeach
              </select>
            </div>

            <div class="bt-drop-in-wrapper">
                <div id="bt-dropin"></div>
            </div>
        </section>

        <input id="nonce" name="payment_method_nonce" type="hidden" />
        <button class="button" type="submit"><span>Test Transaction</span></button>
    </form>>Request payment method</button>
    </div>
  </div>
</div>
<script>
   var form = document.querySelector('#payment-form');
        var client_token = "<?php echo($gateway->ClientToken()->generate()); ?>";

        braintree.dropin.create({
          authorization: client_token,
          selector: '#bt-dropin',
          paypal: {
            flow: 'vault'
          }
        }, function (createErr, instance) {
          if (createErr) {
            console.log('Create Error', createErr);
            return;
          }
          form.addEventListener('submit', function (event) {
            event.preventDefault();

            instance.requestPaymentMethod(function (err, payload) {
              if (err) {
                console.log('Request Payment Method Error', err);
                return;
              }

              // Add the nonce to the form and submit
              document.querySelector('#nonce').value = payload.nonce;
              form.submit();
            });
          });
        });
</script>
@endsection