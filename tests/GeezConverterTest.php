<?php

namespace Geezify\PHPUnit;

use Geezify\Converter\GeezConverter;

class GeezConverterTest extends TestCase
{
    /**
     * @var GeezConverter
     */
    protected $converter;

    /**
     * @param $number
     * @param $geez_number
     *
     * @throws \Geezify\Exception\NotAnIntegerArgumentException
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
     * @throws \Geezify\Exception\NotAnIntegerArgumentException
     * @dataProvider invalidNumberDataProvider
     * @expectedException \Geezify\Exception\NotAnIntegerArgumentException
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
