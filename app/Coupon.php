<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public function discount($subtotal)
    {
        $remise = $subtotal * (1 - $this->percent_off/100);
        return $remise;
    }
}
