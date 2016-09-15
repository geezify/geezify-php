<?php

namespace Andegna\Geez\PHPUnit;

use Andegna\Geez\Converter\GeezConverter;

class GeezConverterTest extends TestCase
{
    /** @var GeezConverter */
    protected $converter;

    /**
     * @param $number
     * @param $geez_number
     *
     * @dataProvider geezNumberTestDataProvider
     */
    public function test_geez_converter($number, $geez_number)
    {
        $result = $this->converter->convert($number);

        $this->assertEquals($geez_number, $result);
    }

    /**
     * @param $number
     *
     * @dataProvider invalidNumberDataProvider
     * @expectedException \Andegna\Geez\Exception\NotAnIntegerArgumentException
     */
    public function test_invalid_number_throw_exception($number)
    {
        $this->converter->convert($number);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->converter = new GeezConverter();
    }

}
