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

    public static function create (float $price, string $selector) : self
    {
        return new self(0,$price,$selector);
    }

    public function replenish (float $count) : void
    {
        $this->count = $this->count + $count;
    }

}