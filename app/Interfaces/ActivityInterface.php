<?php

namespace App\Interfaces;

interface ActivityInterface extends BaseInterface
{
    public function adminContentActivity($page, $size, $filterTitle,$filterInitDate,$filterFinishDate,$filterCategory,$filterPrice);
    public function save($activity);

}