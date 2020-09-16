<?php

namespace jcduran\VendingMachineTest\Application;

use jcduran\VendingMachine\Application\ServiceMode;
use jcduran\VendingMachine\Domain\Entity\AvailableChange;
use jcduran\VendingMachine\Domain\Entity\AvailableItems;
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

    private function whenItRechargeItems(VendingMachine $vendingMachine, Items $items)
    {
        $serviceMode = new ServiceMode($vendingMachine);
        $serviceMode->__invoke($items, new Coins([]));
    }

    private function thenItShouldHaveThisAvailableItems(VendingMachine $vendingMachine, Items $items)
    {
        $this->assertEquals($items->getIterator(), $vendingMachine->availableItems()->getIterator());

    }


    private function givenAVendingMachineWithSomeItemsInside(Items $items): VendingMachine
    {
        $availableItems = new AvailableItems((array)$items->getIterator());
        return new VendingMachine($availableItems, new AvailableChange([]), new InsertedMoney([]));
    }

}
