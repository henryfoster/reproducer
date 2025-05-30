<?php

namespace App\DataFixtures;

use App\Factory\OrderFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $order1 = OrderFactory::createOne(['name' => 'order1', 'position' => 1]);
        $order2 = OrderFactory::createOne(['name' => 'order2', 'position' => 2]);

        $manager->flush();
    }
}
