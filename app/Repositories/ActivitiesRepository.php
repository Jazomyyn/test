<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Interfaces\ActivityInterface;
use Carbon\Carbon;

class ActivitiesRepository implements ActivityInterface{

    /**
     * @var Activity
     */

    protected $model;

    /**
     * @param Activity $model
     */

    public function __construct (Activity $model){

        $this->model = $model;
    }

  
    public function adminContentActivity($page, $size, $filterTitle, $filterInitDate, $filterFinishDate, $filterCategory, $filterPrice)
    {
        $skip = $page * $size;
        
        $query = $this->model::with(['category']);

        if($filterTitle!=null)$query=$query->where('title','like','%'.$filterTitle.'%' );
        if ($filterInitDate != null){
            $query =$query->whereDate('init_date','like',Carbon::parse($filterInitDate));
        }
        if ($filterFinishDate != null){
            $query =$query->whereDate('finish_date','like',Carbon::parse($filterFinishDate));
        }
        if($filterCategory!=null){
            $query = $query->whereHas('category',function ($q) use ($filterCategory){
                $q->where('id','like','%'.$filterCategory.'%');
            });
        }
        if($filterPrice!=null)$query=$query->where('unit_price','like','%'.$filterPrice.'%' );
      
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
        return $this->model::where('active',1)->with(['activities_items.item','category'])->orderBy('popularity', 'desc')->get();
    }
    public function find($idActivity)
    {
        return $this->model::find($idActivity);
    }
    public function save($activity)
    {
        return $activity->save();
    }
}