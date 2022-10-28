<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('index', ['any'=>'home']);
});

Route::get('/tech/{any}', function () {
    return view('tech.home.index');
    })->where('any', '.*')
        ->name('index');

//***********Categories***********//

Route::get('/categories/index-content',
[CategoryController::class, 'indexContent'])
    ->name('categories.index_content');

Route::get('/all/categories',
[CategoryController::class, 'getAllCategories'])
        ->name('categories.all');


//***********Activities***********//
Route::get('/activities/index-content',
[ActivityController::class, 'indexContent'])
    ->name('activities.index_content');

Route::get('/activities/home-filter/{date}/{person}',
[ActivityController::class, 'getActivityDateAndPerson'])
    ->name('activities.home_filter');

Route::get('/all/activities',
[ActivityController::class, 'getAllActivities'])
    ->name('activities.all');

Route::get('/activities/{date}/{quantityPersons}/{idActivity}/validate-and-calculate',
[ActivityController::class, 'validateAndPrice'])
    ->name('activities.validate_calculate');

Route::post('/activities/change-status/{id}',
[ActivityController::class, 'changeStatus'])
        ->name('activities.change_status');

Route::post('/activities/change-category/{id}',
[ActivityController::class, 'changeCategory'])
        ->name('activities.change_category');


//***********Reservations***********//
Route::get('/reservations/index-content',
[ReservationController::class, 'indexContent'])
    ->name('reservation.index_content');

Route::post('/reservations/create',
[ReservationController::class, 'createReservation'])
    ->name('reservation.create');


