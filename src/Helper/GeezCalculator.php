<?php

namespace Andegna\Geez\Helper;

use Andegna\Geez\Converter\Converter;
use SplQueue as Queue;

class GeezCalculator
{
    const ONE = 1;
    const HUNDRED = 100;
    const TEN_THOUSAND = 10000;

    /**  @var Queue */
    protected $queue;

    /** @var  integer */
    protected $total;

    /** @var  integer */
    protected $sub_total;


    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
        $this->total = 0;
    }

    public function calculator()
    {
        $this->resetSubTotalToZero();

        foreach ($this->queue as $token) {
            $this->processToken($token);
        }
    }

    protected function resetSubTotalToZero()
    {
        $this->sub_total = 0;
    }

    /**
     * @param $token
     */
    protected function processToken($token)
    {
        $block = $token['block'];
        $separator = $token['separator'];

        $this->processSeparator($block, $separator);
    }

    protected function processSeparator($block, $separator)
    {
        switch ($separator) {
            case self::ONE:
                $this->updateTotal($block);
                break;
            case self::HUNDRED:
                if ($this->isLeadingHundred($block)) {
                    $block = self::ONE;
                }

                $this->updateSubTotal($block);
                break;
            case self::TEN_THOUSAND:
                if ($this->isLeadingTenThousand($block)) {
                    $block = self::ONE;
                }

                $this->updateTotal($block);
                $this->multiplyTotalBy10k();
                break;
        }
    }

    /**
     * @param $block
     * @return int
     */
    protected function updateTotal($block)
    {
        $this->total += ($this->sub_total + $block);
        $this->resetSubTotalToZero();
    }

    /**
     * @param $block
     * @return bool
     */
    protected function isLeadingHundred($block)
    {
        return
            $this->isBlockZero($block) &&
            $this->isSubtotalZero();
    }

    protected function isBlockZero($block)
    {
        return $this->isZero($block);
    }

    protected function isZero($number)
    {
        return Converter::isZero($number);
    }

    protected function isSubtotalZero()
    {
        return $this->isZero($this->sub_total);
    }

    /**
     * @param $block
     */
    protected function updateSubTotal($block)
    {
        $this->sub_total += ($block * self::HUNDRED);
    }

    protected function isLeadingTenThousand($block)
    {
        return
            $this->isBlockZero($block) &&
            $this->isTotalZero() &&
            $this->isSubtotalZero();
    }

    protected function isTotalZero()
    {
        return $this->isZero($this->total);
    }

    protected function multiplyTotalBy10k()
    {
        $this->total *= self::TEN_THOUSAND;
    }

    /**
     * @return integer
     */
    public function getCalculated()
    {
        return $this->total;
    }

}
