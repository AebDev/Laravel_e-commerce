<?php

namespace App\Listeners;

use App\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CartUpdatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $code = request()->session()->get('coupon');
        $coupon = Coupon::where('code',$code)->first();

        if($coupon){
            session()->put('coupon',[
                'code' => $coupon->code,
                'remise' => $coupon->discount(Cart::subTotal())
            ]);
        }
}
}