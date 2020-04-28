<?php

namespace App\Enums;

use ReflectionClass;

class InvoiceType
{
    const REGISTER = 0;
    const COMMENT = 1;
    const ARTICLE = 2;

    public static function toString($type) {
        $reflection = new ReflectionClass(static::class);

        foreach ($reflection->getConstants() as $key => $value) {
            if ($value === (int) $type) {
                return ucfirst(strtolower($key));
            }
        }

        return 'Unknown';
    }
}