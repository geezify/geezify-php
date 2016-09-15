<?php

namespace Andegna\Geez\PHPUnit;

use Andegna\Geez\Geezify;

class GeezifyTest extends TestCase
{

    public function test_random_numbers()
    {
        $geezify = Geezify::create();

        for ($i = 0; $i < 10000; $i++) {
            $random_number = rand(1, 9999999999);

            $geez_number = $geezify->toGeez($random_number);
            $ascii_number = $geezify->toAscii($geez_number);

            $this->assertEquals($random_number, $ascii_number);
        }
    }
}
