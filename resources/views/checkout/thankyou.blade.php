@extends('layouts.master')

@section('content')
    <div class="col-md-12 alert alert-dark text-center py-5">
        <p class="display-2 py-3">Merci !</p>
        <p class="h3 py-3">votre commande a ete traite avec succes</p>
    <a name="" id="" class="btn btn-primary my-3" href="{{route('products.index')}}" role="button">Vers la boutique</a>
    </div>
@endsection