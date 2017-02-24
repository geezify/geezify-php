<?php

namespace Geezify\Helper;

use Geezify\Converter\Converter;
use SplQueue as Queue;

/**
 * GeezCalculator calculate the ascii number from the parsed queue.
 *
 * @author Sam As End <4sam21{at}gmail.com>
 */
class GeezCalculator
{
    const ONE = 1;

    const HUNDRED = 100;

    const TEN_THOUSAND = 10000;

    /**
     * @var Queue
     */
    protected $queue;

    /**
     * @var int
     */
    protected $total;

    /**
     * @var int
     */
    protected $sub_total;

    /**
     * GeezCalculator constructor.
     *
     * @param Queue $queue
     */
    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
        $this->total = 0;
    }

    /**
     * Do the magic.
     */
    public function calculate()
    {
        $this->resetSubTotalToZero();

        foreach ($this->queue as $token) {
            $this->processToken($token);
        }
    }

    /**
     * set the sub total attribute to zero.
     */
    protected function resetSubTotalToZero()
    {
        $this->sub_total = 0;
    }

    /**
     * Process a single token from the Queue.
     *
     * @param $token
     */
    protected function processToken($token)
    {
        list($block, $separator) = $this->fetchBlockAndSeparator($token);

        $this->processBySeparator($block, $separator);
    }

    /**
     * Fetch the block and separator from the token.
     *
     * @param $token
     *
     * @return array
     */
    protected function fetchBlockAndSeparator($token)
    {
        $block = $token['block'];
        $separator = $token['separator'];

        // This method looks dumb but it's for z sack of clarity
        return [
            $block,
            $separator,
        ];
    }

    /**
     * Process based on separator.
     *
     * @param $block
     * @param $separator
     */
    protected function processBySeparator($block, $separator)
    {
        if ($separator == self::ONE) {
            $this->addToTotal($block);
        } elseif ($separator == self::HUNDRED) {
            $this->updateSubTotal($block);
        } elseif ($separator == self::TEN_THOUSAND) {
            $this->updateTotal($block);
        }
    }

    /**
     * Add the sub total and the block to total
     * and reset sub total to zero.
     *
     * @param $block
     *
     * @return void
     */
    protected function addToTotal($block)
    {
        $this->total += ($this->sub_total + $block);
        $this->resetSubTotalToZero();
    }

    /**
     * Is the leading block?
     *
     * @param $block
     *
     * @return bool
     */
    protected function isLeading($block)
    {
        return
            $this->isBlockZero($block) &&
            $this->isSubtotalZero();
    }

    /**
     * Is the value of block zero?
     *
     * @param $block
     *
     * @return bool
     */
    protected function isBlockZero($block)
    {
        return $this->isZero($block);
    }

    /**
     * Is a number zero?
     *
     * @param $number
     *
     * @return bool
     */
    protected function isZero($number)
    {
        return Converter::isZero($number);
    }

    /**
     * Is sub total attribute zero?
     *
     * @return bool
     */
    protected function isSubtotalZero()
    {
        return $this->isZero($this->sub_total);
    }

    /**
     * Add number to sun total.
     *
     * @param $number integer
     */
    protected function addToSubTotal($number)
    {
        $this->sub_total += $number;
    }

    /**
     * Is the leading 10k?
     *
     * @param $block
     *
     * @return bool
     */
    protected function isLeadingTenThousand($block)
    {
        return
            $this->isTotalZero() &&
            $this->isLeading($block);
    }

    /**
     * Is the total attribute zero?
     *
     * @return bool
     */
    protected function isTotalZero()
    {
        return $this->isZero($this->total);
    }

    /**
     * Multiply the total attribute by ten thousand.
     */
    protected function multiplyTotalBy10k()
    {
        $this->total *= self::TEN_THOUSAND;
    }

    /**
     * Return the calculated ascii number.
     *
     * @return int
     */
    public function getCalculated()
    {
        return $this->total;
    }

    /**
     * Update the sub total attribute.
     *
     * @param $block
     */
    protected function updateSubTotal($block)
    {
        if ($this->isLeading($block)) {
            $block = self::ONE;
        }

        $block *= self::HUNDRED;

        $this->addToSubTotal($block);
    }

    /**
     * Update the sub total attribute.
     *
     * @param $block
     */
    protected function updateTotal($block)
    {
        if ($this->isLeadingTenThousand($block)) {
            $block = self::ONE;
        }

        $this->addToTotal($block);
        $this->multiplyTotalBy10k();
    }
}
