<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){

        if(request('slug')){
            $products = Product::with('categories')->whereHas('categories',function ($query)
            {
                $query->where('slug',request('slug'));
            })->orderBy('created_at','DESC')->paginate(6);
        }else{

           $products = Product::with('categories')->orderBy('created_at','DESC')->paginate(6);
            // $products =  Product::inRandomOrder()->take(6)->get();
        }
        
        
        return view('products.index',compact('products'));
    }

    public function show($slug){

        $product = Product::where('slug',$slug)->firstorfail();
        $stock = $product->stock === 0 ? 'Indisponible' : 'Disponible';
        return view('products.show',compact('product','stock'));
    }

    public function search()
    {
        request()->validate([
            'q' => 'required|min:3'
        ]);
    
        $req = request('q');
        $products  = Product::where('title','like',"%$req%")
        ->orwhere('description','like',"%$req%")
        ->orderBy('created_at','DESC')
        ->paginate(6);
        return view('products.search',compact('products'));
    }
}
