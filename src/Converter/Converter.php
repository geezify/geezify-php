<?php

namespace Geezify\Converter;

/**
 * Converter class provide the base functionality
 * for the Ascii and Geez converters.
 *
 * @author Sam As End <4sam21{at}gmail.com>
 */
abstract class Converter
{
    // i don't want readers to think it's a white
    // space, it's just an empty string
    const EMPTY_CHARACTER = '';

    const GEEZ_NUMBERS = [
        0     => '', '፩', '፪', '፫', '፬', '፭', '፮', '፯', '፰', '፱', '፲',
        20    => '፳',
        30    => '፴',
        40    => '፵',
        50    => '፶',
        60    => '፷',
        70    => '፸',
        80    => '፹',
        90    => '፺',
        100   => '፻',
        10000 => '፼',
    ];

    /**
     * Check if a number is strictly ZERO.
     *
     * @param int $number
     *
     * @return bool if true it's zero
     */
    public static function isZero($number)
    {
        return $number === 0;
    }

    abstract public function convert($number);

    /**
     * Checks if the number is ፻.
     *
     * @param string $geez_number
     *
     * @return bool
     */
    protected function isGeezNumberHundred($geez_number)
    {
        return $this->isGeezNumber($geez_number, 100);
    }

    /**
     * Checks if the geez number character is equal to ascii number.
     *
     * @param string $geez_number
     * @param int    $number
     *
     * @return bool
     */
    protected function isGeezNumber($geez_number, $number)
    {
        return $geez_number === self::GEEZ_NUMBERS[$number];
    }

    /**
     * Checks if the number is ፩.
     *
     * @param $geez_number
     *
     * @return bool
     */
    protected function isGeezNumberOne($geez_number)
    {
        return $this->isGeezNumber($geez_number, 1);
    }

    /**
     * Checks if the number is ፼
     *
     * @param $geez_number
     *
     * @return bool
     */
    protected function isGeezNumberTenThousand($geez_number)
    {
        return $this->isGeezNumber($geez_number, 10000);
    }
}
