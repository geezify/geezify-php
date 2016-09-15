<?php

namespace Andegna\Geez\PHPUnit;

use Andegna\Geez\Geezify;

class WhatATest extends TestCase
{
    public function test_random_numbers()
    {
        $geezify = Geezify::create();

        for ($i = 0; $i < 1000; $i++) {
            $random_number = random_int(1, 9999999999);

            $geez_number = $geezify->toGeez($random_number);
            $ascii_number = $geezify->toAscii($geez_number);

            $this->assertEquals($random_number, $ascii_number);
        }
    }
}
