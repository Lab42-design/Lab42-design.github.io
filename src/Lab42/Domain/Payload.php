<?php

declare(strict_types = 1);

namespace Lab42\Domain;

use Lab42\Payload\DomainPayloadInterface;

class Payload implements DomainPayloadInterface
{
    public function __construct(string $status, array $result = [])
    {
        $this->status = $status;
        $this->result = $result;
    }

    public function getStatus() : string
    {
        return $this->status;
    }

    public function getResult() : array
    {
        return $this->result;
    }

    public static function found(array $result = []) : Payload
    {
        return new Payload(Status::FOUND, $result);
    }

    public static function notFound(array $result = []) : Payload
    {
        return new Payload(Status::NOT_FOUND, $result);
    }
}
