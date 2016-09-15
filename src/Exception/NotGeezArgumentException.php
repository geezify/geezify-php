<?php

namespace Andegna\Geez\Exception;

use InvalidArgumentException;

class NotGeezArgumentException extends InvalidArgumentException
{

    public function __construct($argument)
    {
        parent::__construct(
            "Not a geez number!, {$argument} given."
        );
    }

}
