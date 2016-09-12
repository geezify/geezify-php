<?php

namespace Andegna\Geez;

class Geezify
{
    const EMPTY_CHARACTER = '';

    public static $GEEZ_NUMBERS = [
        0 => '',
        '፩',
        '፪',
        '፫',
        '፬',
        '፭',
        '፮',
        '፯',
        '፰',
        '፱',
        '፲',
        20 => '፳',
        30 => '፴',
        40 => '፵',
        50 => '፶',
        60 => '፷',
        70 => '፸',
        80 => '፹',
        90 => '፺',
        100 => '፻',
        10000 => '፼',
    ];

    /**
     * Convert an arabic number like <b>1, 21, 3456</b> to
     * geez number <b>፩, ፳፩, ፴፬፻፶፮</b>
     *
     * @param int $ascii_number
     *
     * @return string
     * @throws \InvalidArgumentException if the number is not an integer
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
     * @param $ascii_number
     *
     * @return array
     */
    protected function prepareForConversion($ascii_number)
    {
        $validated_number = $this->validateArabicNumber($ascii_number);

        $validated_number = "{$validated_number}";

        $length = \strlen($validated_number);

        $number = $this->prependSpaceIfLengthIsEven($validated_number, $length);

        return [$number, $length];
    }

    /**
     * @param $ascii_number
     *
     * @return mixed
     */
    protected function validateArabicNumber($ascii_number)
    {
        if (!is_integer($ascii_number)) {
            throw new NotAnIntegerArgumentException($ascii_number);
        }

        return $ascii_number;
    }

    /**
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
     * @param $ascii_number
     *
     * @return bool
     */
    protected function isOdd($ascii_number)
    {
        return !$this->isEven($ascii_number);
    }

    /**
     * @param $number
     *
     * @return bool
     */
    protected function isEven($number)
    {
        return $number % 2 === 0;
    }

    /**
     * @param $number
     * @param $index
     * @param $length
     *
     * @return string
     */
    protected function parseEachTwoCharactersBlock($number, $index, $length)
    {
        $geezNumber = $this->getGeezNumberOfTheBlock($number, $index);

        $bet = $this->getBet($length, $index);

        $geezSeparator = $this->getGeezSeparator($bet);

        return $this->combineNumberAndSeparator($geezNumber, $geezSeparator, $index);
    }

    /**
     * @param $number
     * @param $index
     *
     * @return string
     */
    protected function getGeezNumberOfTheBlock($number, $index)
    {
        $block = substr($number, $index, 2);

        $tenth = (int)$block[0];
        $once = (int)$block[1];

        return
            static::$GEEZ_NUMBERS[$tenth * 10] .
            static::$GEEZ_NUMBERS[$once];
    }

    /**
     * @param $length
     * @param $index
     *
     * @return int
     */
    protected function getBet($length, $index)
    {
        $reverse_index = ($length - 1) - $index;

        return intval($reverse_index / 2);
    }

    /**
     * @param $bet
     *
     * @return string
     */
    protected function getGeezSeparator($bet)
    {
        if ($this->isZero($bet)) {
            return static::EMPTY_CHARACTER;
        } elseif ($this->isOdd($bet)) {
            return static::$GEEZ_NUMBERS[100];
        } else {
            return static::$GEEZ_NUMBERS[10000];
        }
    }

    /**
     * @param int $index
     *
     * @return bool
     */
    protected function isZero($index)
    {
        return $index === 0;
    }

    /**
     * @param string $geezNumber
     * @param string $separator
     * @param int $index
     *
     * @return string
     */
    protected function combineNumberAndSeparator($geezNumber, $separator, $index)
    {
        if ($this->shouldRemoveGeezSeparator($geezNumber, $separator)) {
            $separator = static::EMPTY_CHARACTER;
        }

        if ($this->shouldRemoveGeezNumberBlock($geezNumber, $separator, $index)) {
            $geezNumber = static::EMPTY_CHARACTER;
        }

        return $geezNumber . $separator;
    }

    /**
     * @param string $block
     * @param string $separator
     *
     * @return bool
     */
    protected function shouldRemoveGeezSeparator($block, $separator)
    {
        return
            empty($block) &&
            $this->isGeezNumber100($separator);
    }

    /**
     * @param string $separator
     *
     * @return bool
     */
    protected function isGeezNumber100($separator)
    {
        return $this->isGeezNumber($separator, 100);
    }

    /**
     * @param string $geez_number
     * @param int $number
     *
     * @return bool
     */
    protected function isGeezNumber($geez_number, $number)
    {
        if (!isset(static::$GEEZ_NUMBERS[$number])) {
            return false;
        }

        return $geez_number === static::$GEEZ_NUMBERS[$number];
    }

    /**
     * @param $block
     * @param $separator
     * @param $index
     * @return bool
     */
    protected function shouldRemoveGeezNumberBlock($block, $separator, $index)
    {
        return
            $this->isOneHundred($block, $separator) ||
            $this->isLeadingTenThousand($block, $separator, $index);
    }

    /**
     * @param $block
     * @param $separator
     *
     * @return bool
     */
    protected function isOneHundred($block, $separator)
    {
        return
            $this->isGeezNumber100($separator) &&
            $this->isGeezNumberOne($block);
    }

    /**
     * @param $geez
     *
     * @return bool
     */
    protected function isGeezNumberOne($geez)
    {
        return $this->isGeezNumber($geez, 1);
    }

    /**
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

    /**
     * @param $geez
     *
     * @return bool
     */
    protected function isGeezNumberTenThousand($geez)
    {
        return $this->isGeezNumber($geez, 10000);
    }

}
