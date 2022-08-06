<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\Processor;

use Ikuzo\SyliusAvisVerifiesPlugin\EligibilityChecker\OrderEligibilityCheckerInterface;
use Ikuzo\SyliusAvisVerifiesPlugin\Message\SendOrderToAvisVerifies;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Ikuzo\SyliusAvisVerifiesPlugin\Provider\PreQualifiedOrdersProviderInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class AvisVerifiesOrdersProcessor implements AvisVerifiesOrdersProcessorInterface
{
    use LoggerAwareTrait;

    public function __construct(
        PreQualifiedOrdersProviderInterface $preQualifiedOrdersProvider,
        OrderEligibilityCheckerInterface $orderEligibilityChecker,
        MessageBusInterface $bus
    ) 
    {
        $this->logger = new NullLogger();
        $this->preQualifiedOrdersProvider = $preQualifiedOrdersProvider;
        $this->orderEligibilityChecker = $orderEligibilityChecker;
        $this->bus = $bus;
    }

    public function process(): void
    {
        $preQualifiedOrders = $this->preQualifiedOrdersProvider->getOrders();

        $this->logger->info(sprintf(
            'Checking %s order(s)...',
            count($preQualifiedOrders)
        ));

        foreach ($preQualifiedOrders as $order) {
            if ($this->orderEligibilityChecker->isEligible($order)) {
                $this->bus->dispatch(new SendOrderToAvisVerifies($order->getId()));
            }
        }
    }
}
