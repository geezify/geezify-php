<?php

namespace Geezify\PHPUnit;

use Geezify\Converter\AsciiConverter;
use Geezify\Converter\GeezConverter;
use Geezify\Geezify;
use Prophecy\Prophet;

class GeezifyTest extends TestCase
{
    /** @var Prophet */
    protected $prophet;

    protected function setup()
    {
        $this->prophet = new Prophet();
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }

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

    public function test_geezify_build_process()
    {
        // let prophesize ;)
        $geez = $this->prophet->prophesize(GeezConverter::class);
        $ascii = $this->prophet->prophesize(AsciiConverter::class);

        // build out thing
        $geezify = new Geezify($geez->reveal(), $ascii->reveal());

        // promise
        $geez->convert(123)->willReturn('giber gaber');
        $ascii->convert('lorem ipsum')->willReturn(321);

        // assert the response
        $this->assertEquals(321, $geezify->toAscii('lorem ipsum'));
        $this->assertEquals('giber gaber', $geezify->toGeez(123));
    }

    public function test_setter_and_getters()
    {
        $geezify = Geezify::create();

        $geez_dummy = $this->prophet->prophesize(GeezConverter::class)->reveal();
        $ascii_dummy = $this->prophet->prophesize(AsciiConverter::class)->reveal();

        $geezify->setGeezConverter($geez_dummy);
        $geezify->setAsciiConverter($ascii_dummy);

        $this->assertEquals($geez_dummy, $geezify->getGeezConverter());
        $this->assertEquals($ascii_dummy, $geezify->getAsciiConverter());
    }
}
