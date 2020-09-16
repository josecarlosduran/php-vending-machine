<?php

declare(strict_types=1);


namespace jcduran\VendingMachine\Domain\Entity;


use jcduran\VendingMachine\Util\Collection;

final class AvailableItems extends Collection
{


    protected function type(): string
    {
        return Item::class;

    }

    public function rechargeItem(Item $item): void
    {

        $allItemsInsideMachine = $this->items();
        $update = false;
        foreach ($allItemsInsideMachine as $offset => $itemInsideMachine) {
            if ($itemInsideMachine->selector() === $item->selector()) {
                $itemInsideMachine->replenish($item->count());
                $itemInsideMachine->changePrice($item->price());
                $allItemsInsideMachine[$offset] = $itemInsideMachine;
                $update = true;

            }
        }

        if (!$update)
        {
            $allItemsInsideMachine[] = Item::create($item->count(), $item->price(), $item->selector());
        }

        $this->refreshItems($allItemsInsideMachine);
    }


    public function recharge(Items $items)
    {


        foreach ($items as $item) {
            $this->rechargeItem($item);
        }


    }
}