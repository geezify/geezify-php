<?php

namespace Andegna\Geez\Exception;

use InvalidArgumentException;

class NotAnIntegerArgumentException extends InvalidArgumentException
{
    public function __construct($argument)
    {
        parent::__construct(
            sprintf(
                "Not an integer!, %s given.",
                gettype($argument)
            )
        );
    }
}
