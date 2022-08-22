<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\Model;

interface AvisVerifiesProductReviewInterface {
    public function getSource(): string;
    public function setSource(?string $input): void;
    public function getIdSource(): ?string;
    public function setIdSource(?string $input): void;
    public function getRawSource(): ?array;
    public function setRawSource(?array $input): void;

}