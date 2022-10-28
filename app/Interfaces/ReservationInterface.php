<?php

namespace App\Interfaces;

interface ReservationInterface extends BaseInterface
{

    public function adminContentReservation($page, $size, $filterActivity,$filterPrice,$filterPerson,$filterActivityDate, $filterReservationDate);
    public function createReservation(array $reservation);
    
}