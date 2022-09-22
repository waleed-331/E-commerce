<?php


namespace App\Http\Classes;


use Carbon\Carbon;

class Discount
{
    public static function discount($expiration_date,$price,$periods,$discounts)
    {
        for ($i = 0 ; $i < 2; $i++){
        if (Carbon::parse($expiration_date)->subDays($periods[$i])->isAfter(Carbon::today())) {
            $price = $price - ($price * $discounts[$i]);
            return $price;
        }
    }
return $price - ($price * $discounts[2]);
}
    }
