<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cart.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $duplicata = Cart::search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id == $request->product_id;
        });;
        
        if ($duplicata->isNotEmpty()) {
            return redirect()->route('products.index')->with('success','le produite a deja ete ajouter');
        }

        $product = Product::find($request->product_id);

        Cart::add($product->id,$product->title,1,$product->price)
        ->associate('App\Product');

        return redirect()->route('products.index')->with('success','le produite a bien ete ajouter');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rowId)
    {
        $data = $request->json()->all();
        
        $Validator = Validator::make($request->all(),[
            'qty' => 'required|numeric|between:1,6'
            ]);
        
        if ($Validator->fails()) {
            Session::flash('danger', 'La quantité du produit ne doit pas passée à ' . $data['qty'] . '.');
            return response()->json(['error' => 'Cart Quantity Has Not Been Updated']);
        }
        if($data['qty'] > $data['stock']){
            Session::flash('danger', 'La quantité du produit et pas disponible.');
            return response()->json(['error' => 'Cart Quantity Has Not Been Updated']);
        }
        Cart::update($rowId, $data['qty']);

        Session::flash('success', 'La quantité du produit est passée à ' . $data['qty'] . '.');
        return response()->json(['success' => 'Cart Quantity Has Been Updated']);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowId)
    {
        Cart::remove($rowId);
        return back()->with('success','le produite a ete supprimer.');
    }

    public function storeCoupon()
    {
        request()->validate([
            'code' => 'required|min:1'
        ]);
    
        $coupon = Coupon::where('code','like',request('code'))->first();
        if(!$coupon){
            return redirect()->back()->with('danger','coupon est invalide');
        }
        else{
            session()->put('coupon',[
                'code' => $coupon->code,
                'remise' => $coupon->discount(Cart::subTotal())
            ]);
            return redirect()->back()->with('success','le coupon est applique');

            
        }
    }
   

    public function destroyCoupon()
    {
        session()->forget('coupon');
        return redirect()->back()->with('success','le coupon est retirer');
    }  
}
