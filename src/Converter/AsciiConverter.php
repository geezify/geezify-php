<?php

namespace Andegna\Geez\Converter;

use Andegna\Geez\Helper\GeezCalculator;
use Andegna\Geez\Helper\GeezParser;
use SplQueue as Queue;

/**
 * Class AsciiConverter
 *
 * @package Andegna\Geez\Converter
 */
class AsciiConverter extends Converter
{

    /**
     * @param $_number
     *
     * @return integer
     */
    public function convert($_number)
    {
        $parsed = $this->parse($_number);

        return $this->calculate($parsed);
    }

    /**
     * @param $geez_number
     *
     * @return Queue
     */
    protected function parse($geez_number)
    {
        $parser = new GeezParser($geez_number);
        $parser->parse();

        return $parser->getParsed();
    }

    /**
     * @param Queue $parsed
     *
     * @return integer
     */
    protected function calculate(Queue $parsed)
    {
        $calculator = new GeezCalculator($parsed);
        $calculator->calculator();

        return $calculator->getCalculated();
    }

}
