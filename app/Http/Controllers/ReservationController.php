<?php

namespace App\Http\Controllers;

use App\Interfaces\ReservationInterface;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    protected $repository;

    public function __construct(ReservationInterface $repository)
    {
        $this->repository = $repository;
    }

    public function indexContent(Request $request){
        $page = $request->get('page', 0);
        $size = $request->get('size', 15);
        $filterActivity = $request->get('filter-activity_title', null); 
        $filterPerson= $request->get('filter-quantity_person', null); 
        $filterActivityDate = $request->get('filter-activity_date', null); 
        $filterReservationDate = $request->get('filter-reservation_date', null); 
        $filterPrice = $request->get('filter-format_total', null);  


        
        return $this->repository->adminContentReservation($page, $size, $filterActivity, $filterPrice, $filterPerson, $filterActivityDate,$filterReservationDate);
    }
    public function createReservation(Request $request){
        $reservation = $request->only([
            'total_price',
            'quantity_person',
            'reservation_date',
            'activity_date',
            'fk_id_activity'
        ]);

        return Controller::completeResponse(true,__('messages.success'),$this->repository->createReservation($reservation));
    }
}
