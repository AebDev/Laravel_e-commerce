@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach (auth()->user()->orders as $order)
                        <div class="card">
                            <div class="card-header">
                                Commande passee le {{Carbon\Carbon::parse($order->created_at)->format('d/m/Y à H:i')}} d un montant de {{getPrice($order->amount)}}
                            </div>
                            <div class="card-body">
                                <strong>Lists des produits</strong>
                                <table class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nom produit</th>
                                        <th scope="col">Montant</th>
                                        <th scope="col">Quantite</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @foreach (unserialize($order->products) as $product)
                                      <tr>
                                      <th scope="row">1</th>
                                        <td>{{$product[0]}}</td>
                                        <td>{{getPrice($product[1])}}</td>
                                        <td>{{$product[2]}}</td>
                                      </tr>
                                      @endforeach
                                      
                                    </tbody>
                                  </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
