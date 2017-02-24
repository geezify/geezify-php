<?php

namespace Geezify\Exception;

use InvalidArgumentException;

/**
 * Class NotGeezArgumentException.
 *
 * @author Sam As End <4sam21{at}gmail.com>
 */
class NotGeezArgumentException extends InvalidArgumentException
{
    public function __construct($argument)
    {
        parent::__construct(
            "Not a geez number!, {$argument} given."
        );
    }
}
