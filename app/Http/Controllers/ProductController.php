<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){

        $products =  Product::inRandomOrder()->take(6)->get();
        
        return view('products.index',compact('products'));
    }

    public function show($slug){

        $product = Product::where('slug',$slug)->firstorfail();
        return view('products.show')->with('product',$product);
    }
}
