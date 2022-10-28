<?php

namespace App\Services;


class ActivityService
{
    public static function isValidDate($date,$init_date,$finish_date){
        return ($date >= $init_date) && ($date <= $finish_date);
    }
    public static function priceTotal($quantityPersons,$unit_price){
        return $quantityPersons*$unit_price;
    }

}