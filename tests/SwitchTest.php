<?php

namespace App\Tests;

use App\Factory\OrderFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class SwitchTest extends KernelTestCase
{
    use HasBrowser;
    use ResetDatabase;
    use Factories;

    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }

    public function testSwitch(): void
    {
        $order1 = OrderFactory::createOne(['name' => 'order1', 'position' => 1]);
        $order2 = OrderFactory::createOne(['name' => 'order2', 'position' => 2]);

        $this->browser()
            ->visit('/')
            ->assertSuccessful() // this test should not fail
            ->assertJson();

        $this->assertTrue(true);
    }

}
