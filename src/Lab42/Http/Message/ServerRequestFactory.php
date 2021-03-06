<?php

declare(strict_types = 1);

namespace Lab42\Http\Message;

use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ServerRequestFactory implements ServerRequestFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createServerRequest(string $method, $uri, array $serverParams = []): ServerRequestInterface
    {
        return new ServerRequest($serverParams, [], [], [], null, $method, $uri, [], 'php://temp');
    }
}
