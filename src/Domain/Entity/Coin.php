<?php

declare(strict_types=1);


namespace jcduran\VendingMachine\Domain\Entity;


use Exception;

final class Coin
{
    private const VALID_COIN_VALUES = [0.05,0.10,0.25,1];
    private float $value;

    public function __construct(float $value)
    {
        if (in_array($value,self::VALID_COIN_VALUES,true))
        {
            throw new Exception("This is not a valid Coin Value");
        }

        $this->value = $value;
    }
}