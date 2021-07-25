<?php

namespace App\Enums;

use ReflectionClass;

class HttpMethods
{
    const POST = 1;
    const GET = 2;
    const PATCH = 3;
    const DELETE = 4;
    const PUT = 5;
    const OPTIONS = 6;

    /**
     * @return array
     */
    public static function getEnums(): array
    {
        $reflectionClass = new ReflectionClass(__CLASS__);
        return $reflectionClass->getConstants();
    }
}
