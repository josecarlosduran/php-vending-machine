<?php

declare(strict_types = 1);

namespace jcduran\VendingMachineTest;

use jcduran\VendingMachine\Example;
use PHPUnit\Framework\TestCase;

final class ExampleTest extends TestCase
{

    private ?Example $example;

    private ?string $greeting;

    public function tearDown() : void
    {
        parent::tearDown();

        $this->example = null;
        $this->greeting = null;
    }

    /** @test */
    public function shouldSayHelloWhenGreeting()
    {
        $this->givenAName();

        $this->whenItGreets();

        $this->thenItShouldSayHello();
    }

    private function givenAName()
    {
        $this->example = new Example("Jose");
    }

    private function whenItGreets()
    {
        $this->greeting = $this->example->greet();
    }

    private function thenItShouldSayHello()
    {
        $this->assertEquals("Hello", $this->greeting);
    }
}
