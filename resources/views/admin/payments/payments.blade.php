@extends('layouts.app')

@section('content')

{{-- <div id="dropin-container"></div>
<button id="submit-payment-button">Request payment method</button> --}}

<form action="{{route('admin.payment.make')}}" method="get" id="payment-form">
@csrf
<input id="nonce" name="payment_method_nonce" type="hidden" />
<div id="dropin-container" ></div>
<button type ="submit" id="submit-payment-button">Request payment method</button>
</form>



<script>
  var form = document.querySelector('#payment-form');
  var button = document.querySelector('#submit-payment-button');

braintree.dropin.create({
  authorization: "{{ $clientToken }}",
  selector: '#dropin-container'
}, function (createErr, instance) {

  if(createErr){
    console.log(createErr);
  }
  form.addEventListener('submit', function (event) {
  event.preventDefault();
    instance.requestPaymentMethod(function (err, payload) {
      console.log(payload.nonce);
    if (err) {
      console.log('Request Payment Method Error', err);
      return;
    }
      // Submit payload.nonce to your server
      //console.log(payload.nonce);
      /* $.get("{{ route('admin.payment.make') }}", {payload}, function (response) {
        console.log(response);
        if (response.success) {
        alert('Payment successfull!');
        
        } else {
        alert('Payment failed');
        }
        }, 'json'); */
        document.querySelector('#nonce').value = payload.nonce;
        form.submit();
    });
  });

});
</script>
@endsection