<?php

declare(strict_types = 1);

namespace Lab42\Http\Message;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

final class Request implements RequestInterface
{
    use RequestTrait;

    /**
     * @param string $method
     * @param UriInterface|string $uri
     * @param array $headers
     * @param StreamInterface|string|resource $body
     * @param string $protocol
     */
    public function __construct(
        string $method = 'GET',
        $uri = '',
        array $headers = [],
        $body = 'php://temp',
        string $protocol = '1.1'
    ) {
        $this->init($method, $uri, $headers, $body, $protocol);
    }
}
