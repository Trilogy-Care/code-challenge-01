<?php

namespace App\Services;

abstract class Service
{
    public static function new(): static
    {
        return new static();
    }
}
