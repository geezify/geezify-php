<?php

namespace Geezify;

use Geezify\Converter\AsciiConverter;
use Geezify\Converter\GeezConverter;

/**
 * Geezify converts numbers in ASCII to Geez and vise versa.
 *
 * @author Sam As End <4sam21{at}gmail.com>
 */
class Geezify
{
    /**
     * @var GeezConverter
     */
    protected $geez_converter;

    /**
     * @var AsciiConverter
     */
    protected $ascii_converter;

    /**
     * Geezify constructor.
     *
     * @param GeezConverter  $geez_converter
     * @param AsciiConverter $ascii_converter
     */
    public function __construct(
        GeezConverter $geez_converter,
        AsciiConverter $ascii_converter
    ) {
        $this->geez_converter = $geez_converter;
        $this->ascii_converter = $ascii_converter;
    }

    /**
     * Return a new Geezify instance.
     *
     * @return Geezify
     */
    public static function create()
    {
        return new self(new GeezConverter(), new AsciiConverter());
    }

    /**
     * Converts ASCII number to geez.
     *
     * @param $ascii_number
     *
     * @throws \Geezify\Exception\NotAnIntegerArgumentException
     *
     * @return string
     */
    public function toGeez($ascii_number)
    {
        return $this->geez_converter->convert($ascii_number);
    }

    /**
     * Convert geez to ASCII.
     *
     * @param string $geez_number
     *
     * @throws \Geezify\Exception\NotGeezArgumentException
     *
     * @return int
     */
    public function toAscii($geez_number)
    {
        return $this->ascii_converter->convert($geez_number);
    }

    /**
     * @return GeezConverter
     */
    public function getGeezConverter()
    {
        return $this->geez_converter;
    }

    /**
     * @param GeezConverter $geez_converter
     */
    public function setGeezConverter(GeezConverter $geez_converter)
    {
        $this->geez_converter = $geez_converter;
    }

    /**
     * @return AsciiConverter
     */
    public function getAsciiConverter()
    {
        return $this->ascii_converter;
    }

    /**
     * @param AsciiConverter $ascii_converter
     */
    public function setAsciiConverter(AsciiConverter $ascii_converter)
    {
        $this->ascii_converter = $ascii_converter;
    }
}
