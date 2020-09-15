<?php

declare(strict_types=1);


namespace jcduran\VendingMachine\Domain\Entity;


use jcduran\VendingMachine\Util\Collection;

final class AvailabeItems extends Collection
{


    protected function type(): string
    {
        return Item::class;

    }
}