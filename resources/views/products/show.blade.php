@extends('layouts.master')

@section('content')
<div class="col-md">
  <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
    <div class="col p-4 d-flex flex-column position-static">
      <strong class="d-inline-block mb-2 text-primary">Categorie</strong>
      <h4 class="mb-0">{{$product->title}}</h4>
    <div class="mb-1 text-muted">{{$product->created_at->format('d/m/y')}}</div>
      <p class="card-text mb-auto">{!! $product->description !!}</p>
      <strong class="card-text mb-auto">{{$product->getPrice()}}</strong>
    <form action="{{route('cart.store')}}" method="post">
      @csrf

    <input type="text" hidden name="product_id" value="{{$product->id}}">
        
        <button type="submit" class="btn btn-dark">ajouer au panier</button>
      </form>
    </div>
    <div class="col-auto d-none d-lg-block">
      <img src="/storage/{{$product->image}}" height="250" width="200" alt="">
    </div>
  </div>
</div>
@endsection