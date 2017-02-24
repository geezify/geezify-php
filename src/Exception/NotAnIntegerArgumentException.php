<?php

namespace Geezify\Exception;

use InvalidArgumentException;

/**
 * Class NotAnIntegerArgumentException.
 *
 * @author Sam As End <4sam21{at}gmail.com>
 */
class NotAnIntegerArgumentException extends InvalidArgumentException
{
    public function __construct($argument)
    {
        parent::__construct(
            sprintf(
                'Not an integer!, %s given.',
                gettype($argument)
            )
        );
    }
}
