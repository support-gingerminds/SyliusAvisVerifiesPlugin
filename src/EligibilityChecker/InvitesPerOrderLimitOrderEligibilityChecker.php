<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\EligibilityChecker;

use Ikuzo\SyliusAvisVerifiesPlugin\Model\AvisVerifiesOrderInterface;

final class InvitesPerOrderLimitOrderEligibilityChecker implements OrderEligibilityCheckerInterface
{
    public function isEligible(AvisVerifiesOrderInterface $order): bool
    {
        return $order->getAvisVerifiesEmailsSent() === false;
    }
}
