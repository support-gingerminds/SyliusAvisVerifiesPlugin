<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\Provider;

use Sylius\Component\Core\Model\OrderInterface;

interface PreQualifiedOrdersProviderInterface
{
    /**
     * @return OrderInterface[]
     */
    public function getOrders(): array;
}
