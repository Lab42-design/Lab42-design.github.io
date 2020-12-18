<?php

declare(strict_types = 1);

namespace Filebase\Format;

interface FormatInterface
{
    public static function getFileExtension();
    public static function encode($data, $pretty);
    public static function decode($data);
}
