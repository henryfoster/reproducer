<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SwitchController extends AbstractController
{
    #[Route('/', name: 'app_switch')]
    public function index(
        OrderRepository $orderRepository,
        EntityManagerInterface $entityManager,
    ): Response
    {
        $order1 = $orderRepository->findOneBy(['name' => 'order1']);
        $order2 = $orderRepository->findOneBy(['name' => 'order2']);

        if (!$order1 || !$order2) {
            return new Response('run fixtures: docker compose exec -T php bin/console do:fi:lo');
        }

        $order1Pos = $order1->getPosition();
        $order1->setPosition($order2->getPosition());
        $order2->setPosition($order1Pos);

        $entityManager->flush();

        return $this->json([
            $order1->toArray(),
            $order2->toArray(),
        ]);
    }
}
