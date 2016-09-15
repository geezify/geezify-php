<?php

namespace Andegna\Geez\Converter;

abstract class Converter
{
    const EMPTY_CHARACTER = '';

    public static $GEEZ_NUMBERS = [
        0 => '', '፩', '፪', '፫', '፬', '፭', '፮', '፯', '፰', '፱', '፲',
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

    public abstract function convert($_number);

    /**
     * @param string $separator
     *
     * @return bool
     */
    protected function isGeezNumberHundred($separator)
    {
        return $this->isGeezNumber($separator, 100);
    }

    /**
     * @param string $geez_number
     * @param int    $number
     *
     * @return bool
     */
    protected function isGeezNumber($geez_number, $number)
    {
        return $geez_number === self::$GEEZ_NUMBERS[$number];
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
     * @param $geez
     *
     * @return bool
     */
    protected function isGeezNumberTenThousand($geez)
    {
        return $this->isGeezNumber($geez, 10000);
    }

    /**
     * @param int $index
     *
     * @return bool
     */
    public static function isZero($index)
    {
        return $index === 0;
    }

}
