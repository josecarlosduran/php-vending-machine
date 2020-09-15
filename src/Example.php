<?php

declare(strict_types = 1);

namespace jcduran\VendingMachine;

final class Example
{
    /** string */
    private const GREETING = "Hello";


    private string $name;

    public function __construct(string $aName)
    {
        $this->name = $aName;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function greet(): string
    {
        return self::GREETING;
    }
}
