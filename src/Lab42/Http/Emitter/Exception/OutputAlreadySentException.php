<?php

declare(strict_types = 1);

namespace Lab42\Http\Emitter\Exception;

use RuntimeException;

class OutputAlreadySentException extends RuntimeException
{
    /**
     * @return self
     */
    public static function create(): self
    {
        return new self('Unable to emit response; output has been emitted previously.');
    }
}
