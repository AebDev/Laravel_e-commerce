@extends('layouts.master')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('checkout-script')
<script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')
    <div class="col-md-12">
        <h1>Page de paiment</h1>
        <div class="row">
            <div class="col-md-6">
            <form class="my-4" action="{{route('checkout.store')}}" method="POST" id="payment-form">
                @csrf
                    <div id="card-element" >
                      <!-- Elements will create input elements here -->
                    </div>
                  
                    <!-- We'll put the error messages in this element -->
                    <div id="card-errors" role="alert"></div>
                  
                <button class="btn btn-success mt-4" id="submit">passer la commande {{getPrice(Cart::total())}}</button>
                  </form>
            </div>
        </div>
    </div>
@endsection

@section('script-js')
    <script>
        var stripe = Stripe('pk_test_j3jq6eNV9f3JL7YCEWXkGi2K00jASNTvyU');
        var elements = stripe.elements();

        var style = {
    base: {
      color: "#32325d",
      fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
      fontSmoothing: "antialiased",
      fontSize: "16px",
      "::placeholder": {
        color: "#aab7c4"
      }
    },
    invalid: {
      color: "#fa755a",
      iconColor: "#fa755a"
    }
  };

  var card = elements.create("card", { style: style });
card.mount("#card-element");

card.addEventListener('change', ({error}) => {
  const displayError = document.getElementById('card-errors');
  if (error) {
    displayError.textContent = error.message;
    displayError.classList.add('alert','alert-warning');

  } else {
    displayError.textContent = '';
    displayError.classList.remove('alert','alert-warning');
  }
});

var form = document.getElementById('payment-form');
var submitbutton = document.getElementById('submit');
form.addEventListener('submit', function(ev) {
  ev.preventDefault();
  submitbutton.disabled = true;
  stripe.confirmCardPayment("{{ $clientSecret }}", {
    payment_method: {
      card: card
    }
  }).then(function(result) {
    if (result.error) {
        submitbutton.disabled = false;
      // Show error to your customer (e.g., insufficient funds)
      console.log(result.error.message);
    } else {
      // The payment has been processed!
      if (result.paymentIntent.status === 'succeeded') {
        
        var paymentIntent = result.paymentIntent;
        var token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var url = form.action;
        var redirect = '/merci';

        fetch(
            url,
            {
              headers: {
                      "Content-Type": "application/json",
                      "Accept": "application/json, text-plain, */*",
                      "X-Requested-With": "XMLHttpRequest",
                      "X-CSRF-TOKEN": token
                  },

                method: 'Post',

                body:JSON.stringify({
                    paymentIntent: paymentIntent
                })
            }).then((data)=>{
              if(data.status === 400){
                var redirect = '/boutique';
              }
              else{
                var redirect = '/merci';
              }
            
            window.location.href = redirect;
            }).catch((error)=>{
            
            })
          }}
  });
});
    </script>
@endsection