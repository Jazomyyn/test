<?php

namespace App\Services;


class FormatPricesService
{
    public static function formatPrice($total){
        if($total>1000000000000){
            return "$".number_format(($total/1000000000000),2, '.', ',').' Trillones';
        }
        else if($total>1000000000){
            return "$".number_format(($total/1000000000),2, '.', ',').' Billones';
        } else{
            return "$".number_format($total, 2, '.', ',');
        }
    }

}