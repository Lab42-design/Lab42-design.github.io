<?php

declare(strict_types = 1);

namespace Lab42\Http\Message;

use InvalidArgumentException;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

use function is_string;

final class StreamFactory implements StreamFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createStream(string $content = ''): StreamInterface
    {
        $stream = new Stream();
        $stream->write($content);
        $stream->rewind();
        return $stream;
    }

    /**
     * {@inheritdoc}
     */
    public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        return new Stream($filename, $mode);
    }

    /**
     * {@inheritdoc}
     *
     * @psalm-suppress DocblockTypeContradiction
     */
    public function createStreamFromResource($resource): StreamInterface
    {
        if (is_string($resource)) {
            throw new InvalidArgumentException('Invalid stream provided. It must be a stream resource.');
        }

        return new Stream($resource);
    }
}
