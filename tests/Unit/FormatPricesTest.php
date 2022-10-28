<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\FormatPricesService;

class FormatPricesTest extends TestCase
{
    /**
     * A basic unit test.
     *
     * @test
     */
    public function format_applied_correctly()
    {
        $price = 20567;
        $format_price = '$20,567.00';

        $service = new FormatPricesService();
        $response = $service->formatPrice($price);

        $this->assertEquals($format_price,$response);

    }
}
