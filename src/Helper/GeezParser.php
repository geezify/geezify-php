<?php

namespace Andegna\Geez\Helper;

use Andegna\Geez\Converter\Converter;
use Andegna\Geez\Exception\NotGeezArgumentException;
use SplQueue as Queue;

class GeezParser
{
    /** @var  string */
    protected $geez_number;

    /** @var Queue */
    protected $parsed;

    public function __construct($geez_number)
    {
        $this->setGeezNumber($geez_number);
    }

    protected function setGeezNumber($geez_number)
    {
        if (!is_string($geez_number)) {
            throw new NotGeezArgumentException(gettype($geez_number));
        }

        $this->geez_number = $geez_number;
    }

    public function getParsed()
    {
        if (is_null($this->parsed)) {
            $this->parse();
        }

        return $this->parsed;
    }

    public function parse()
    {
        $this->parsed = new Queue();

        $block = 0;

        $length = $this->getLength($this->geez_number);

        for ($index = 0; $index < $length; $index++) {
            $this->parseCharacter($index, $block);
        }

        $this->pushToQueue($block, 1);
    }

    protected function getLength($geez_number)
    {
        return \mb_strlen($geez_number, 'UTF-8');
    }

    protected function parseCharacter($index, &$block)
    {
        $ascii_number = $this->parseGeezAtIndex($index);

        if (!$this->isGeezSeparator($ascii_number)) {
            $block += $ascii_number;
        } else {
            $this->pushToQueue($block, $ascii_number);
            $block = 0;
        }
    }

    /**
     * @param $i
     * @return mixed
     */
    protected function parseGeezAtIndex($i)
    {
        $geez_char = $this->getCharacterAt($this->geez_number, $i);

        return $this->getAsciiNumber($geez_char);
    }

    protected function getCharacterAt($geez_number, $index)
    {
        return \mb_substr($geez_number, $index, 1, 'UTF-8');
    }

    protected function getAsciiNumber($geez_number)
    {
        $ascii_number = @\array_search($geez_number, Converter::$GEEZ_NUMBERS, true);

        if ($ascii_number === false) {
            throw new NotGeezArgumentException($geez_number);
        }

        return $ascii_number;
    }

    /**
     * @param $ascii_number
     * @return bool
     */
    protected function isGeezSeparator($ascii_number)
    {
        return $ascii_number > 99;
    }

    /**
     * @param $block
     * @param $ascii_number
     */
    protected function pushToQueue($block, $ascii_number)
    {
        $this->parsed->push(
            [
                'block' => $block,
                'separator' => $ascii_number,
            ]
        );
    }

}
