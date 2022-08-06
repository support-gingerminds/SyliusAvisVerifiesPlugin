<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\EligibilityChecker;

use Ikuzo\SyliusAvisVerifiesPlugin\Model\AvisVerifiesOrderInterface;

interface OrderEligibilityCheckerInterface
{
    public function isEligible(AvisVerifiesOrderInterface $order): bool;
}
