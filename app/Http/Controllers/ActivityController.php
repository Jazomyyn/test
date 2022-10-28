<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ActivityService;
use App\Interfaces\ActivityInterface;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    
    protected $repository;

    public function __construct(ActivityInterface $repository)
    {
        $this->repository = $repository;
    }

    public function indexContent(Request $request){
        $page = $request->get('page', 0);
        $size = $request->get('size', 15);
        $filterTitle = $request->get('filter-title', null); 
        $filterInitDate = $request->get('filter-init_date', null); 
        $filterFinishDate = $request->get('filter-finish_date', null); 
        $filterCategory = $request->get('filter-category', null);
        $filterPrice = $request->get('filter-format_total', null);  


        
        return $this->repository->adminContentActivity($page, $size, $filterTitle,$filterInitDate,$filterFinishDate,$filterCategory,$filterPrice);
    }


    public function getActivityDateAndPerson($date, $persons){

        $activities = $this->repository->getAll();

        $dataBetweenDates = [];
       
        $i=0;

        foreach ($activities as $activity)
        {
            if (ActivityService::isValidDate($date, $activity->init_date, $activity->finish_date)){
                $dataBetweenDates [$i]["activity"]= $activity;
                $dataBetweenDates [$i]["price_total"]= ActivityService::priceTotal($persons, $activity->unit_price);
                $i++;
            }
            
        }
       
        return Controller::completeResponse(true,__('messages.success'),$dataBetweenDates);
     
    }
    public function getAllActivities(){
        return Controller::completeResponse(true,__('messages.success'), $this->repository->getAll());
      
    }
    public function validateAndPrice($date,$quantityPersons,$idActivity){
        $activity = $this->repository->find($idActivity);
        $data = [];
        
        $data['isValid'] = ActivityService::isValidDate($date, $activity->init_date, $activity->finish_date);
        $data += [ "price" => ActivityService::priceTotal($quantityPersons, $activity->unit_price)];

        return Controller::completeResponse(true,__('messages.success'),  $data);
    }

    public function changeStatus($idActivity){
        $activity = $this->repository->find($idActivity);
        $activity->active = !$activity->active;

        return Controller::completeResponse(true,__('messages.success'),  $this->repository->save($activity));
    }
    public function changeCategory(Request $request,$idActivity){
        $activity = $this->repository->find($idActivity);
        $activity->fk_id_category = $request->get('fk_id_category');

        return Controller::completeResponse(true,__('messages.success'),  $this->repository->save($activity));
    }
    
}
