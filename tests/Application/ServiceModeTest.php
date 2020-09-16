<?php

namespace jcduran\VendingMachineTest\Application;

use jcduran\VendingMachine\Application\ServiceMode;
use jcduran\VendingMachine\Domain\Entity\AvailableChange;
use jcduran\VendingMachine\Domain\Entity\AvailableItems;
use jcduran\VendingMachine\Domain\Entity\Coin;
use jcduran\VendingMachine\Domain\Entity\Coins;
use jcduran\VendingMachine\Domain\Entity\InsertedMoney;
use jcduran\VendingMachine\Domain\Entity\Item;
use jcduran\VendingMachine\Domain\Entity\Items;
use jcduran\VendingMachine\Domain\Entity\VendingMachine;
use PHPUnit\Framework\TestCase;

class ServiceModeTest extends TestCase
{


    /** @test */


    public function shouldRechargeItemsInAEmptyMachine()
    {
        $vendingMachine = $this->givenAEmptyVendingMachine();
        $items          = $this->givenSomeItems();

        $this->whenItRechargeItems($vendingMachine, $items);

        $this->thenItShouldHaveThisAvailableItems($vendingMachine, $items);

    }


    /** @test */


    public function shouldRechargeItems()
    {
        $items           = $this->givenSomeItems();
        $itemsToRecharge = new Items([
            Item::create(20, 2.00, 'Example 1')
        ]);

        $itemsResult = new Items([
            Item::create(30, 2.00, 'Example 1'),
            Item::create(5, 3.00, 'Example 2'),
            Item::create(20, 1.50, 'Example 3'),
        ]);



        $vendingMachine  = $this->givenAVendingMachineWithSomeItemsInside($items);


        $this->whenItRechargeItems($vendingMachine, $itemsToRecharge);

        $this->thenItShouldHaveThisAvailableItems($vendingMachine, $itemsResult);

    }


    /** @test */

    public function shouldRechargeCoinsInAEmptyMachine()
    {
        $vendingMachine = $this->givenAEmptyVendingMachine();
        $coins          = $this->givenSomeCoins();

        $this->whenItRechargeCoins($vendingMachine, $coins);

        $this->thenItShouldHaveThisAvailableCoins($vendingMachine, $coins);

    }

    /** @test */

    public function shouldRechargeCoins()
    {
        $coins          = $this->givenSomeCoins();
        $vendingMachine  = $this->givenAVendingMachineWithSomeCoinsInside($coins);

        $coinsToRecharge = new Coins([
            Coin::create(1.00, 10)
        ]);

        $coinsResult =  new Coins([
            Coin::create(0.05, 20),
            Coin::create(0.10, 50),
            Coin::create(0.25,50),
            Coin::create(1.00,12),
        ]);


        $this->whenItRechargeCoins($vendingMachine, $coinsToRecharge);

        $this->thenItShouldHaveThisAvailableCoins($vendingMachine, $coinsResult);

    }


    private function givenAEmptyVendingMachine(): VendingMachine
    {
        return VendingMachine::createEmpty();
    }

    private function givenSomeItems(): Items
    {
        return new Items([
            Item::create(10, 1.10, 'Example 1'),
            Item::create(5, 3.00, 'Example 2'),
            Item::create(20, 1.50, 'Example 3'),
        ]);

    }

    private function givenSomeCoins(): Coins
    {
        return new Coins([
            Coin::create(0.05, 20),
            Coin::create(0.10, 50),
            Coin::create(0.25,50),
            Coin::create(1.00,2),
        ]);

    }

    private function whenItRechargeItems(VendingMachine $vendingMachine, Items $items)
    {
        $serviceMode = new ServiceMode($vendingMachine);
        $serviceMode->__invoke($items, new Coins([]));
    }

    private function whenItRechargeCoins(VendingMachine $vendingMachine, Coins $coins)
    {
        $serviceMode = new ServiceMode($vendingMachine);
        $serviceMode->__invoke(new Items([]), $coins);
    }

    private function thenItShouldHaveThisAvailableItems(VendingMachine $vendingMachine, Items $items)
    {
        $this->assertEquals($items->getIterator(), $vendingMachine->availableItems()->getIterator());

    }

    private function thenItShouldHaveThisAvailableCoins(VendingMachine $vendingMachine, Coins $coins)
    {
        $this->assertEquals($coins->getIterator(), $vendingMachine->availableChange()->getIterator());

    }




    private function givenAVendingMachineWithSomeItemsInside(Items $items): VendingMachine
    {
        $availableItems = new AvailableItems((array)$items->getIterator());
        return new VendingMachine($availableItems, new AvailableChange([]), new InsertedMoney([]));
    }

    private function givenAVendingMachineWithSomeCoinsInside(Coins $coins): VendingMachine
    {
        $availableChange = new AvailableChange((array)$coins->getIterator());
        return new VendingMachine(new AvailableItems([]), $availableChange, new InsertedMoney([]));
    }



}
