<?php

namespace Geezify\Converter;

use Geezify\Exception\NotAnIntegerArgumentException;

/**
 * GeezConverter converts ascii number like <b>1986</b>
 * to equivalent geez number like <b>፲፱፻፹፮</b>.
 *
 * @author Sam As End <4sam21{at}gmail.com>
 */
class GeezConverter extends Converter
{
    /**
     * Convert an ascii number like <b>1, 21, 3456</b> to
     * geez number <b>፩, ፳፩, ፴፬፻፶፮</b>.
     *
     * @param int $ascii_number
     *
     * @throws NotAnIntegerArgumentException if the number is not an integer
     *
     * @return string
     */
    public function convert($ascii_number)
    {
        list($number, $length) = $this->prepareForConversion($ascii_number);

        $result = static::EMPTY_CHARACTER;

        for ($index = 0; $index < $length; $index += 2) {
            $result .= $this->parseEachTwoCharactersBlock($number, $index, $length);
        }

        return $result;
    }

    /**
     * - Validate the number
     * - Convert the number to a string
     * - Get the length of the number
     * - Prepend a space if the length is odd.
     *
     * @param $ascii_number
     *
     * @throws \Geezify\Exception\NotAnIntegerArgumentException
     *
     * @return array the $number and the $length
     */
    protected function prepareForConversion($ascii_number)
    {
        $validated_number = $this->validateAsciiNumber($ascii_number);

        $validated_number = "{$validated_number}";

        $length = \strlen($validated_number);

        $number = $this->prependSpaceIfLengthIsEven($validated_number, $length);

        // return the number too ... i don't wanna "strlen" again
        return [
            $number,
            $length,
        ];
    }

    /**
     * Validate if the number is ascii number.
     *
     * @param $ascii_number
     *
     * @throws NotAnIntegerArgumentException
     *
     * @return int
     */
    protected function validateAsciiNumber($ascii_number)
    {
        if (!is_int($ascii_number)) {
            throw new NotAnIntegerArgumentException($ascii_number);
        }

        return $ascii_number;
    }

    /**
     * Prepend space if the length of the number is odd.
     *
     * @param $ascii_number
     * @param $length
     *
     * @return string
     */
    protected function prependSpaceIfLengthIsEven($ascii_number, $length)
    {
        if ($this->isOdd($length)) {
            return " {$ascii_number}";
        }

        return $ascii_number;
    }

    /**
     * Is a number odd?
     *
     * @param $ascii_number
     *
     * @return bool
     */
    protected function isOdd($ascii_number)
    {
        return !$this->isEven($ascii_number);
    }

    /**
     * Is a number even?
     *
     * @param $number
     *
     * @return bool
     */
    protected function isEven($number)
    {
        return ($number % 2) === 0;
    }

    /**
     * Parse each two character block.
     *
     * @param $number
     * @param $index
     * @param $length
     *
     * @return string
     */
    protected function parseEachTwoCharactersBlock($number, $index, $length)
    {
        $geez_number = $this->getGeezNumberOfTheBlock($number, $index);

        $bet = $this->getBet($length, $index);

        $geez_separator = $this->getGeezSeparator($bet);

        return $this->combineBlockAndSeparator($geez_number, $geez_separator, $index);
    }

    /**
     * Fetch the two character (00-99) block and convert it to geez.
     *
     * @param $number
     * @param $index
     *
     * @return string geez two character block
     */
    protected function getGeezNumberOfTheBlock($number, $index)
    {
        $block = $this->getBlock($number, $index);

        $tenth = (int) $block[0];
        $once = (int) $block[1];

        return
            static::GEEZ_NUMBERS[($tenth * 10)].static::GEEZ_NUMBERS[$once];
    }

    /**
     * Fetch two characters from the $number starting from $index.
     *
     * @param $number string the whole ascii number
     * @param $index  integer the starting position
     *
     * @return string
     */
    protected function getBlock($number, $index)
    {
        return \substr($number, $index, 2);
    }

    /**
     * The ቤት of the block.
     *
     * @param $length integer the length of the ascii number
     * @param $index  integer the character index
     *
     * @return int
     */
    protected function getBet($length, $index)
    {
        $reverse_index = (($length - 1) - $index);

        // i didn't use floor instead of 'floor' b/c it returns a
        // float and 'intval' gives the same thing in integer
        return intval($reverse_index / 2);
    }

    /**
     * Get the separator depending on the bet.
     *
     * @param $bet
     *
     * @return string return ፻,፼ or empty character
     */
    protected function getGeezSeparator($bet)
    {
        if ($this->isZero($bet)) {
            return static::EMPTY_CHARACTER;
        } elseif ($this->isOdd($bet)) {
            return static::GEEZ_NUMBERS[100];
        } else {
            return static::GEEZ_NUMBERS[10000];
        }
    }

    /**
     * Combines the block and the separator.
     *
     * @param string $geez_number
     * @param string $separator
     * @param int    $index       of the block
     *
     * @return string
     */
    protected function combineBlockAndSeparator(
        $geez_number,
        $separator,
        $index
    ) {
        if ($this->shouldRemoveGeezSeparator($geez_number, $separator)) {
            $separator = static::EMPTY_CHARACTER;
        }

        if ($this->shouldRemoveGeezNumberBlock($geez_number, $separator, $index)) {
            $geez_number = static::EMPTY_CHARACTER;
        }

        return $geez_number.$separator;
    }

    /**
     * Returns true if the block is empty and the separator is 100.
     *
     * @param string $block
     * @param string $separator
     *
     * @return bool
     */
    protected function shouldRemoveGeezSeparator($block, $separator)
    {
        return
            empty($block) &&
            $this->isGeezNumberHundred($separator);
    }

    /**
     * Returns true if the ascii number is 100 or
     * if the ascii number is the leading 10000.
     *
     * @param $block
     * @param $separator
     * @param $index
     *
     * @return bool
     */
    protected function shouldRemoveGeezNumberBlock($block, $separator, $index)
    {
        return
            $this->isOneHundred($block, $separator) ||
            $this->isLeadingTenThousand($block, $separator, $index);
    }

    /**
     * Returns true if the number is 100.
     *
     * @param $block
     * @param $separator
     *
     * @return bool
     */
    protected function isOneHundred($block, $separator)
    {
        return
            $this->isGeezNumberHundred($separator) &&
            $this->isGeezNumberOne($block);
    }

    /**
     * Returns true if the number is the leading 10000.
     *
     * @param $block
     * @param $separator
     * @param $index
     *
     * @return bool
     */
    protected function isLeadingTenThousand($block, $separator, $index)
    {
        return
            $this->isZero($index) &&
            $this->isGeezNumberOne($block) &&
            $this->isGeezNumberTenThousand($separator);
    }
}
