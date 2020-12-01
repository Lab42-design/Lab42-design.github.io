<?php

declare(strict_types = 1);

namespace Lab42\Http\Response;

use Lab42\Http\Message\ResponseTrait;
use Lab42\Http\Message\Stream;

/**
 * Trait extends the standard functionality defined in `Psr\Http\Message\ResponseInterface`.
 *
 * @see https://github.com/php-fig/http-message/tree/master/src/ResponseInterface.php
 */
trait ResponseExtensionTrait
{
    use ResponseTrait;

    /**
     * Sets the provided Content-Type, if none is already present.
     *
     * @param string $contentType
     */
    private function setContentTypeHeaderIfNotExists(string $contentType): void
    {
        if (!$this->hasHeader('content-type')) {
            $this->headerNames['content-type'] = 'Content-Type';
            $this->headers[$this->headerNames['content-type']] = [$contentType];
        }
    }

    /**
     * Create the message body.
     *
     * @param string $content
     * @return Stream
     */
    private function createBody(string $content = ''): Stream
    {
        $stream = new Stream();
        $stream->write($content);
        $stream->rewind();
        return $stream;
    }
}
