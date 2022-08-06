<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\EligibilityChecker;

use Ikuzo\SyliusAvisVerifiesPlugin\Model\AvisVerifiesOrderInterface;
use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Webmozart\Assert\Assert;

final class CompositeOrderEligibilityChecker implements OrderEligibilityCheckerInterface
{
    /** @var OrderEligibilityCheckerInterface[] */
    private $orderEligibilityCheckers;

    /**
     * @param OrderEligibilityCheckerInterface[] $orderEligibilityCheckers
     */
    public function __construct(RewindableGenerator $orderEligibilityCheckers)
    {
        Assert::notEmpty($orderEligibilityCheckers);
        Assert::allIsInstanceOf($orderEligibilityCheckers, OrderEligibilityCheckerInterface::class);

        $this->orderEligibilityCheckers = $orderEligibilityCheckers;
    }

    public function isEligible(AvisVerifiesOrderInterface $order): bool
    {
        foreach ($this->orderEligibilityCheckers as $orderEligibilityChecker) {
            if (!$orderEligibilityChecker->isEligible($order)) {
                return false;
            }
        }

        return true;
    }
}
