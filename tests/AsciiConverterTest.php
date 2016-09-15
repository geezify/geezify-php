<?php

namespace Andegna\Geez\PHPUnit;

use Andegna\Geez\Converter\AsciiConverter;

class AsciiConverterTest extends TestCase
{
    /** @var AsciiConverter */
    protected $converter;

    /**
     * @param $ascii
     * @param $geez
     *
     * @throws \Andegna\Geez\Exception\NotGeezArgumentException
     * @dataProvider geezNumberTestDataProvider
     */
    public function test_ascii_converter($ascii, $geez)
    {
        $result = $this->converter->convert($geez);

        $this->assertEquals($ascii, $result, "$geez");
    }

    /**
     * @param $value
     *
     * @throws \Andegna\Geez\Exception\NotGeezArgumentException
     * @dataProvider invalidNumberDataProvider
     * @expectedException Andegna\Geez\Exception\NotGeezArgumentException
     */
    public function test_invalid_number_throw_exception($value)
    {
        $this->converter->convert($value);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->converter = new AsciiConverter();
    }
}
