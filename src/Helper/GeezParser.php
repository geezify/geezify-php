<?php

namespace Geezify\Helper;

use Geezify\Converter\Converter;
use Geezify\Exception\NotGeezArgumentException;
use SplQueue as Queue;

/**
 * GeezParser parse the geez number to a queue.
 */
class GeezParser
{
    /**
     * @var string
     */
    protected $geez_number;

    /**
     * @var Queue
     */
    protected $parsed;

    /**
     * GeezParser constructor.
     *
     * @param $geez_number
     *
     * @throws NotGeezArgumentException
     */
    public function __construct($geez_number)
    {
        $this->setGeezNumber($geez_number);
        $this->parsed = null;
    }

    /**
     * @param $geez_number
     *
     * @throws NotGeezArgumentException
     */
    protected function setGeezNumber($geez_number)
    {
        if (!is_string($geez_number)) {
            throw new NotGeezArgumentException(gettype($geez_number));
        }

        $this->geez_number = $geez_number;
    }

    public function getParsed()
    {
        return $this->parsed;
    }

    /**
     * Swing the magic wand and say the spell.
     */
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

    /**
     * Get the length of the string.
     *
     * @param $geez_number
     *
     * @return int
     */
    protected function getLength($geez_number)
    {
        return \mb_strlen($geez_number, 'UTF-8');
    }

    /**
     * Parse a geez character.
     *
     * @param $index integer
     * @param $block integer
     *
     * @throws \Geezify\Exception\NotGeezArgumentException
     */
    protected function parseCharacter($index, &$block)
    {
        $ascii_number = $this->parseGeezAtIndex($index);

        if ($this->isNotGeezSeparator($ascii_number)) {
            $block += $ascii_number;
        } else {
            $this->pushToQueue($block, $ascii_number);
            $block = 0;
        }
    }

    /**
     * Get the ascii number from geez number string.
     *
     * @param $index
     *
     * @throws \Geezify\Exception\NotGeezArgumentException
     *
     * @return int
     */
    protected function parseGeezAtIndex($index)
    {
        $geez_char = $this->getCharacterAt($this->geez_number, $index);

        return $this->getAsciiNumber($geez_char);
    }

    /**
     * Fetch z character at $index from the geez number string.
     *
     * @param $geez_number
     * @param $index
     *
     * @return string
     */
    protected function getCharacterAt($geez_number, $index)
    {
        return \mb_substr($geez_number, $index, 1, 'UTF-8');
    }

    /**
     * Convert geez number character to ascii.
     *
     * @param $geez_number
     *
     * @throws NotGeezArgumentException
     *
     * @return int
     */
    protected function getAsciiNumber($geez_number)
    {
        $ascii_number = array_search($geez_number, Converter::GEEZ_NUMBERS, true);

        if ($ascii_number === false) {
            throw new NotGeezArgumentException($geez_number);
        }

        return $ascii_number;
    }

    /**
     * @param $ascii_number
     *
     * @return bool
     */
    protected function isNotGeezSeparator($ascii_number)
    {
        return $ascii_number < 99;
    }

    /**
     * Push to the queue.
     *
     * @param $block
     * @param $separator
     */
    protected function pushToQueue($block, $separator)
    {
        $this->parsed->push(
            compact('block', 'separator')
        );
    }
}
