<?php

namespace Andegna\Geez;
use Andegna\Geez\Converter\AsciiConverter;
use Andegna\Geez\Converter\Converter;
use Andegna\Geez\Converter\GeezConverter;

/**
 * Class Geezify
 *
 * @package Andegna\Geez
 */
class Geezify
{
    /**
     * @var Converter
     */
    protected $geez;

    /**
     * @var Converter
     */
    protected $ascii;

    /**
     * Geezify constructor.
     *
     * @param Converter $geez
     * @param Converter $ascii
     */
    public function __construct(Converter $geez, Converter $ascii)
    {
        $this->geez = $geez;
        $this->ascii = $ascii;
    }

    public static function create()
    {
        return new self(new GeezConverter(), new AsciiConverter());
    }

    public function toGeez($ascii_number)
    {
        return $this->geez->convert($ascii_number);
    }

    public function toAscii($geez_number)
    {
        return $this->ascii->convert($geez_number);
    }

}
