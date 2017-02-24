<?php

namespace Geezify\Converter;

use Geezify\Exception\NotGeezArgumentException;
use Geezify\Helper\GeezCalculator;
use Geezify\Helper\GeezParser;
use SplQueue as Queue;

/**
 * AsciiConverter converts geez number like <b>፲፱፻፹፮</b>
 * to equivalent ascii number like <b>1986</b>.
 *
 * @author Sam As End <4sam21{at}gmail.com>
 */
class AsciiConverter extends Converter
{
    /**
     * Accepts geez number and return an integer.
     *
     * @param $geez_number string to be converted
     *
     * @throws NotGeezArgumentException if the valid geez number
     *
     * @return int the ascii representation
     */
    public function convert($geez_number)
    {
        $parsed = $this->parse($geez_number);

        return $this->calculate($parsed);
    }

    /**
     * Parse the geez number number to a queue.
     *
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
     * Calculate the ascii from the parsed queue.
     *
     * @param Queue $parsed
     *
     * @return int
     */
    protected function calculate(Queue $parsed)
    {
        $calculator = new GeezCalculator($parsed);
        $calculator->calculate();

        return $calculator->getCalculated();
    }
}
