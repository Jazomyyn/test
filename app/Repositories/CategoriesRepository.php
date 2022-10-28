<?php

namespace App\Repositories;

use App\Interfaces\CategoryInterface;
use App\Models\Category;

class CategoriesRepository implements CategoryInterface{

    /**
     * @var Category
     */

    protected $model;

    /**
     * @param Category $model
     */

    public function __construct (Category $model){

        $this->model = $model;
    }

    public function adminContentCategory($page, $size, $filterName)
    {
        $skip = $page * $size;
        
        $query = $this->model::query();

        if($filterName!=null)$query=$query->where('name','like','%'.$filterName.'%' );
      
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
}