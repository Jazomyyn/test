<?php

namespace App\Interfaces;

interface CategoryInterface extends BaseInterface
{
    public function adminContentCategory($page, $size, $filterName);
}