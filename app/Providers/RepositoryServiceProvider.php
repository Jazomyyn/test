<?php

namespace App\Providers;

use App\Interfaces\ActivityInterface;
use App\Interfaces\CategoryInterface;
use App\Interfaces\ReservationInterface;
use App\Repositories\ActivitiesRepository;
use App\Repositories\CategoriesRepository;
use App\Repositories\ReservationsRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindingSomething(ActivityInterface::class, ActivitiesRepository::class);
        $this->bindingSomething(CategoryInterface::class, CategoriesRepository::class);
        $this->bindingSomething(ReservationInterface::class, ReservationsRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function bindingSomething($interface, $repository){
        $this->app->bind($interface, $repository);
    }
}