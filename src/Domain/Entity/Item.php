<?php

declare(strict_types=1);


namespace jcduran\VendingMachine\Domain\Entity;


final class Item
{
    private int $count;
    private float $price;
    private string $selector;

    public function __construct(int $count,float $price,string $selector)
    {
        $this->count = $count;
        $this->price = $price;
        $this->selector = $selector;
    }

    public static function create (int $count, float $price, string $selector) : self
    {
        return new self($count,$price,$selector);
    }

    public function replenish (int $count) : void
    {
        $this->count = $this->count + $count;
    }
    public function changePrice (float $newPrice) : void
    {
        $this->price = $newPrice;
    }

    public function count(): int
    {
        return $this->count;
    }

    public function price(): float
    {
        return $this->price;
    }

    public function selector(): string
    {
        return $this->selector;
    }






    }