<?php

declare(strict_types = 1);

namespace Lab42\Domain;

use Lab42\Payload\DomainStatusInterface;

interface Status
{
    /**
     * Find succeeded.
     */
    const FOUND = 'FOUND';

    /**
     * Generic success.
     */
    const SUCCESS = 'SUCCESS';

    /**
     * Generic error.
     */
    const ERROR = 'ERROR';

    /**
     * Find failed (n.b.: not an error).
     */
    const NOT_FOUND = 'NOT_FOUND';
}
