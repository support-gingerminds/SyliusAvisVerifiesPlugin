<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\Processor;

use Psr\Log\LoggerAwareInterface;

interface AvisVerifiesOrdersProcessorInterface extends LoggerAwareInterface
{
    public function process(): void;
}
