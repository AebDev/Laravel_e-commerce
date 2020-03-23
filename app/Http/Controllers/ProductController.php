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
            })->paginate(6);
        }else{

           $products = Product::with('categories')->paginate(6);
            // $products =  Product::inRandomOrder()->take(6)->get();
        }
        
        
        return view('products.index',compact('products'));
    }

    public function show($slug){

        $product = Product::where('slug',$slug)->firstorfail();
        return view('products.show')->with('product',$product);
    }
}
