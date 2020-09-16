<?php

declare(strict_types=1);


namespace jcduran\VendingMachine\Domain\Entity;


final class VendingMachine
{

    private AvailableItems $availableItems;
    private AvailableChange $availableChange;
    private InsertedMoney $insertedMoney;

    public function __construct(AvailableItems $availableItems, AvailableChange $availableChange, InsertedMoney  $insertedMoney)
    {
        $this->availableItems = $availableItems;
        $this->availableChange = $availableChange;
        $this->insertedMoney = $insertedMoney;
    }

    public static function createEmpty()
    {
        return new VendingMachine(new AvailableItems([]),new AvailableChange([]),new InsertedMoney([]));
    }


    public function serviceMode(Items $items, Coins $coins)
    {

        $this->availableItems->recharge($items);
        $this->availableChange->recharge($coins);

    }

    public function availableItems(): AvailableItems
    {
        return $this->availableItems;
    }

    public function availableChange(): AvailableChange
    {
        return $this->availableChange;
    }

    public function insertedMoney(): InsertedMoney
    {
        return $this->insertedMoney;
    }



}