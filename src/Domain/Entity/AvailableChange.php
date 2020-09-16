<?php

declare(strict_types=1);


namespace jcduran\VendingMachine\Domain\Entity;


use jcduran\VendingMachine\Util\Collection;

final class AvailableChange extends Collection
{

    protected function type(): string
    {
        return Coin::class;
    }

    public function rechargeCoin(Coin $coin): void
    {

        $allCoinsInsideMachine = $this->items();
        $update = false;
        foreach ($allCoinsInsideMachine as $offset => $coinInsideMachine) {
            if ($coinInsideMachine->value() === $coin->value()) {
                $coinInsideMachine->replenish($coin->count());
                $allCoinsInsideMachine[$offset] = $coinInsideMachine;
                $update = true;

            }
        }

        if (!$update)
        {
            $allCoinsInsideMachine[] = Coin::create($coin->value(),$coin->count());
        }

        $this->refreshItems($allCoinsInsideMachine);
    }


    public function recharge(Coins $coins)
    {
        foreach ($coins as $coin) {
            $this->rechargeCoin($coin);
        }

    }
}