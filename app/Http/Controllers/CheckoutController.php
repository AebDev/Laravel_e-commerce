<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use DateTime;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\PaymentIntent;
class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if (Cart::count() == 0) {
            return redirect()->route('products.index');
        }
        Stripe::setApiKey('sk_test_yg9luttAaHg4ezQE1SelIoXK00rzp7Cxwi');
        $total = Cart::Total();

        if(session('coupon')){
            $total = ((Cart::subTotal() - session('coupon')['remise'])+((Cart::subTotal() - session('coupon')['remise'])*config('cart.tax')/100));
        }

        $intent = PaymentIntent::create([
            'amount' => round($total),
            'currency' => 'eur',
        ]);

        $clientSecret = Arr::get($intent,'client_secret');

        return view('checkout.index',compact('clientSecret','total'));
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
        if ($this->checkIsAvailable()) {
            cart::destroy();
            Session::flash('danger','le stock du produit(s) sélectionné est épuisé.');
            return response()->json(['success' => false],400);
        }
        
        $data = $request->json()->all();
        
        $order = new Order();

        $order->payment_intent_id = $data['paymentIntent']['id'];
        $order->amount = $data['paymentIntent']['amount'];
        $order->payment_created_at = (new DateTime())
        ->setTimestamp($data['paymentIntent']['created'])
        ->format('Y-m-d H:i:s');
        $products = [];
        $i=0;

        foreach (Cart::content() as $product) {
            
            $products['product_'.$i][] = $product->name;
            $products['product_'.$i][] = $product->price;
            $products['product_'.$i][] = $product->qty;
            $i++;
        }
        $order->products = serialize($products);
        $order->user_id = auth()->user()->id;

        $order->save();
        
        if($data['paymentIntent']['status'] === 'succeeded'){
            $this->updatestock();
            if(session('coupon')){
                session()->forget('coupon');
            }
            cart::destroy();
            Session::flash('success','votre commande a ete traite avec succes');
            return response()->json(['success' => 'Payment Intent succeeded']);
        }
        else{
            return response()->json(['error' => 'Payment Intent not succeeded']);
        }

        
    }
    
    public function thankyou(){
        return (Session::has('success')) ? view('checkout.thankyou') : redirect()->route('products.index');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkIsAvailable()
    {
        foreach (Cart::content() as $item) {
            $product = Product::find($item->model->id);
            if($item->qty > $product->stock){
                return true;
            }
            
        }
        return false;
    }

    public function updatestock()
    {
        foreach (Cart::content() as $item) {
            $product = Product::find($item->model->id);
            $product->update(['stock' => $product->stock - $item->qty]);
        }
    }

}
