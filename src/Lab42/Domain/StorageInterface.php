<?php

declare(strict_types = 1);

namespace Lab42\Domain;

interface StorageInterface
{
    public function app(string $id) : string;

    public function path(string $id = '') : string;

    public function glob(string $pattern) : array;

    public function read(string $id) : ?string;

    public function write(string $id, string $text) : void;

    public function exists(string $id) : bool;
}
