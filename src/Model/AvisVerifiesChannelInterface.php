<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\Model;

interface AvisVerifiesChannelInterface {
    
    public function getIsAvisVerifiesActive(): bool;
    public function setIsAvisVerifiesActive(bool $input): void;
    public function setAvisVerifiesSecretKey(string $input): void;
    public function getAvisVerifiesSecretKey(): ?string;
    public function setAvisVerifiesWebsiteId(string $input): void;
    public function getAvisVerifiesWebsiteId(): ?string;
    public function getAvisVerifiesDaysBeforeSent(): int;
    public function setAvisVerifiesDaysBeforeSent(int $input): void;
}