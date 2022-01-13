<?php

namespace App\Tests;

use App\Services\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    // PHPunit test used for own classes tests
    public function testSomething(): void
    {
        $calculator = new Calculator();

        $result = $calculator->add(2,4);

        $this->assertEquals(6,$result);
    }
}
