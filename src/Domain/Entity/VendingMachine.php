<?php

declare(strict_types=1);


namespace jcduran\VendingMachine\Domain\Entity;


final class VendingMachine
{

    private AvailabeItems $availableItems;
    private AvailableChange $availableChange;
    private InsertedMoney $insertedMoney;

}