<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\ActivityService;
use Carbon\Carbon;

class ActivityServiceTest extends TestCase
{
    private $service;

    public function setUp(): void{
        $this->service = new ActivityService();
    }
    /**
     * A basic unit test.
     *
     * @test
     */
    public function valid_dates_correctly()
    {
        $date  = Carbon::now();
        $init_date = Carbon::parse('2022-12-01');
        $finish_date = Carbon::parse('2023-04-21');

    
        $response = $this->service->isValidDate($date, $init_date,$finish_date);

        $this->assertEquals(false,$response);

    }

    public function calculate_price_per_person_correctly()
    {
        $quantityPersons = 10;
        $unit_price = 5;
    
        $response = $this->service->priceTotal($quantityPersons,$unit_price);

        $this->assertEquals(500,$response);

    }
}
