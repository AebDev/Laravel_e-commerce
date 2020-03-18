<?php

function getPrice($priceInDecimal){

    $price = floatVal($priceInDecimal) / 100;

        return number_format($price,2,',',' ').' €';
}