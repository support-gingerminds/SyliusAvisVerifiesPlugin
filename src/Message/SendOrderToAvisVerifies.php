<?php

namespace Ikuzo\SyliusAvisVerifiesPlugin\Message;

class SendOrderToAvisVerifies
{
    private $orderId;

    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }
}