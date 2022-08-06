<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\EligibilityChecker;

use Ikuzo\SyliusAvisVerifiesPlugin\Model\AvisVerifiesChannelInterface;
use Ikuzo\SyliusAvisVerifiesPlugin\Model\AvisVerifiesOrderInterface;

final class ChannelAvisVerifiesActiveChecker implements OrderEligibilityCheckerInterface
{
    public function isEligible(AvisVerifiesOrderInterface $order): bool
    {
        $channel = $order->getChannel();
        if ($channel instanceof AvisVerifiesChannelInterface) {
            if ($channel->getIsAvisVerifiesActive() === true && $channel->getAvisVerifiesSecretKey() !== null && $channel->getAvisVerifiesWebsiteId() !== null)
            {
                return true;
            }
        }
        
        return false;
    }
}
