<?php

namespace Ikuzo\SyliusAvisVerifiesPlugin\EventListener;

use Sylius\Component\Order\Model\OrderInterface;
use Ikuzo\SyliusAvisVerifiesPlugin\EligibilityChecker\OrderEligibilityCheckerInterface;
use Ikuzo\SyliusAvisVerifiesPlugin\Message\SendOrderToAvisVerifies;
use Symfony\Component\Messenger\MessageBusInterface;

class OnOrderFulfilledEvent 
{
    public function __construct(
        OrderEligibilityCheckerInterface $orderEligibilityChecker,
        MessageBusInterface $bus,
    ) 
    {
        $this->orderEligibilityChecker = $orderEligibilityChecker;
        $this->bus = $bus;
    }

    public function sendToAvisVerifies(OrderInterface $order)
    {
        if ($this->orderEligibilityChecker->isEligible($order)) {
            $this->bus->dispatch(new SendOrderToAvisVerifies($order->getId()));
        }
    }
}