<?php

namespace App\Repositories;

use App\Interfaces\ReservationInterface;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationsRepository implements ReservationInterface{

    /**
     * @var Reservation
     */

    protected $model;

    /**
     * @param Reservation $model
     */

    public function __construct (Reservation $model){

        $this->model = $model;
    }

    public function adminContentReservation($page, $size, $filterActivity, $filterPrice, $filterPerson, $filterActivityDate,$filterReservationDate)
    {
        $skip = $page * $size;
        
        $query = $this->model::with(['activity'])->orderBy('id', 'desc');

        if($filterActivity!=null){
            $query = $query->whereHas('activity',function ($q) use ($filterActivity){
                $q->where('title','like','%'.$filterActivity.'%');
            });
        }
        if($filterPrice!=null)$query=$query->where('total_price','like','%'.$filterPrice.'%' );
        if($filterPerson!=null)$query=$query->where('quantity_person','like','%'.$filterPerson.'%' );
        if ($filterActivityDate != null){
            $query =$query->whereDate('activity_date','like',Carbon::parse($filterActivityDate));
        }
        if ($filterReservationDate != null){
            $query =$query->whereDate('reservation_date','like',Carbon::parse($filterReservationDate));
        }
      
        $count = $query->count();
        $data = $query
            ->limit($size)
            ->skip($skip)
            ->get();

        return response()->json([
            'page' => $page,
            'size' => $size,
            'count' => $count,
            'data' => $data,
        ]);
    }
    public function getAll()
    {
        return $this->model::all();
    }
    public function find($idCategory)
    {
        return $this->model::find($idCategory);
    }

    public function createReservation(array $reservation)
    {
        return $this->model::create($reservation);
        
    }
}