<?php

declare(strict_types=1);

namespace Tests\Ikuzo\SyliusAvisVerifiesPlugin\Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ikuzo\SyliusAvisVerifiesPlugin\Model\AvisVerifiesChannelInterface;
use Ikuzo\SyliusAvisVerifiesPlugin\Model\AvisVerifiesChannelTrait;
use Sylius\Component\Core\Model\Channel as BaseChannel;

/**
 * @ORM\Table(name="sylius_channel")
 * @ORM\Entity()
 */
class Channel extends BaseChannel implements AvisVerifiesChannelInterface
{
    use AvisVerifiesChannelTrait;
}