@extends('layouts.master')

@section('content')
<div class="col-md">
  <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
    <div class="col p-4 d-flex flex-column position-static">
     
      <div>
        <div class="badge bade-pill badge-info py-1 ">
          {{$stock}}
        </div>
        @foreach ($product->categories as $categorie)
        <strong class="d-inline-block mb-2 pr-2 text-primary">{{$categorie->name}}</strong>
        @endforeach
      </div>
      <h4 class="mb-0">{{$product->title}}</h4>
    <div class="mb-1 text-muted">{{$product->created_at->format('d/m/y')}}</div>
      <p class="card-text mb-auto">{!! $product->description !!}</p>
      <strong class="card-text mb-auto">{{$product->getPrice()}}</strong>
       @if ($product->stock)
       <form action="{{route('cart.store')}}" method="post">
        @csrf

      <input type="text" hidden name="product_id" value="{{$product->id}}">
        
        <button type="submit" class="btn btn-dark">ajouer au panier</button>
      </form>
       @endif
    </div>
    <div class="col-auto d-none d-lg-block">
      <img src="/storage/{{$product->image}}" height="250" width="200" id="main-image" alt="">
      <div class="mt-2">
        @if ($product->images)
        <img src="/storage/{{$product->image}}" width="50" style="cursor: pointer" class="img-thumbnail" alt="">
        @foreach (json_decode($product->images) as $image)
        <img src="/storage/{{$image}}"  width="50" style="cursor: pointer" class="img-thumbnail" alt="">
        @endforeach
        @endif
      </div>
    </div>
  </div>
</div>
<script>
  var mainimage = document.querySelector('#main-image');
  var thumbnails = document.querySelectorAll('.img-thumbnail');

  thumbnails.forEach(element => element.addEventListener('click',changeimage));
  function changeimage(e) {
    mainimage.src = this.src;
  }
</script>
@endsection