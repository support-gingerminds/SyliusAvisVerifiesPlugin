<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\Model;

interface AvisVerifiesOrderInterface {
    
    public function getAvisVerifiesEmailsSent(): bool;
    public function setAvisVerifiesEmailsSent(bool $input): void;
    public function getAvisVerifiesEmailsSentAt(): ?\DateTime;

}