<?php

declare(strict_types=1);

namespace Tests\Ikuzo\SyliusAvisVerifiesPlugin\Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ikuzo\SyliusAvisVerifiesPlugin\Model\AvisVerifiesOrderInterface;
use Ikuzo\SyliusAvisVerifiesPlugin\Model\AvisVerifiesOrderTrait;
use Sylius\Component\Core\Model\Order as BaseOrder;

/**
 * @ORM\Table(name="sylius_order")
 * @ORM\Entity()
 */
class Order extends BaseOrder implements AvisVerifiesOrderInterface
{
    use AvisVerifiesOrderTrait;
}