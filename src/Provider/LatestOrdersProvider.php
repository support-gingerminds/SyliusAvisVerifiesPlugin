<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\Provider;

use Sylius\Component\Core\Repository\OrderRepositoryInterface;

class LatestOrdersProvider implements PreQualifiedOrdersProviderInterface
{
    protected $orderRepository;
    protected $latestDays;

    public function __construct(OrderRepositoryInterface $orderRepository) {
        $this->orderRepository = $orderRepository;
        // $this->latestDays = $latestDays;
    }

    public function getOrders(): array
    {
        return $this->orderRepository->createListQueryBuilder()
            ->andWhere('o.state = :finalState')
            ->andWhere('o.avisVerifiesEmailsSent = :emailSent')
            ->setParameter('emailSent', false)
            ->setParameter('finalState', 'fulfilled')
            ->getQuery()
            ->getResult();
    }
}
