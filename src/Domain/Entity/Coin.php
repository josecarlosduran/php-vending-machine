<?php

declare(strict_types=1);


namespace jcduran\VendingMachine\Domain\Entity;


use Exception;

final class Coin
{
    private const VALID_COIN_VALUES = [0.05,0.10,0.25,1.00];
    private float $value;
    private int $count;

    public function __construct(float $value,int $count)
    {

        if (!in_array($value,self::VALID_COIN_VALUES,true))
        {
            throw new Exception("This is not a valid Coin Value");
        }

        $this->value = $value;
        $this->count = $count;
    }

    public static function create (float $value,int $count) : self
    {
        return new self($value, $count);
    }

    public function replenish (int $count) : void
    {
        $this->count = $this->count + $count;
    }

    public function value(): float
    {
        return $this->value;
    }

    public function count(): int
    {
        return $this->count;
    }


}