<?php

declare(strict_types=1);


namespace jcduran\VendingMachine\Application;


use jcduran\VendingMachine\Domain\Entity\Coins;
use jcduran\VendingMachine\Domain\Entity\Items;
use jcduran\VendingMachine\Domain\Entity\VendingMachine;

final class ServiceMode
{

    private VendingMachine $vendingMachine;

    public function __construct(VendingMachine $vendingMachine)
    {

        $this->vendingMachine = $vendingMachine;
    }

    public function __invoke(Items $items, Coins $coins)
    {
        $this->vendingMachine->serviceMode($items, $coins);

    }

}