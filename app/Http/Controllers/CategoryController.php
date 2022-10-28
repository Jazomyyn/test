<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\CategoryInterface;

class CategoryController extends Controller
{

    protected $repository;

    public function __construct(CategoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function indexContent(Request $request){
        $page = $request->get('page', 0);
        $size = $request->get('size', 15);
        $filterName = $request->get('filter-name', null); 
        
        return $this->repository->adminContentCategory($page, $size, $filterName);
    }

    public function getAllCategories(){
        return Controller::completeResponse(true,__('messages.success'), $this->repository->getAll());
      
    }

}
