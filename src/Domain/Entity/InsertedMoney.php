<?php

declare(strict_types=1);


namespace jcduran\VendingMachine\Domain\Entity;


use jcduran\VendingMachine\Util\Collection;

final class InsertedMoney extends Collection
{

    protected function type(): string
    {
        return Coin::class;
    }

    public function totalMoney()
    {
        $totalMoney = 0;
        foreach ($this->items() as $coin)
        {
            $totalMoney+=$coin->value;
        }
        return $totalMoney;
    }
}