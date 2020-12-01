<?php

declare(strict_types = 1);

namespace Lab42\Http\Message;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

final class ResponseFactory implements ResponseFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        return new Response($code, [], 'php://temp', '1.1', $reasonPhrase);
    }
}
