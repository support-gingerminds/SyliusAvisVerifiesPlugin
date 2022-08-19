<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\Entity;

use DateTimeInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface ChannelReviewInterface extends ResourceInterface, TimestampableInterface
{
    public function getId(): ?int;

    public function getChannel(): ChannelInterface;

    public function setChannel(ChannelInterface $channel): void;
    
    public function getOrder(): ?OrderInterface;

    public function setOrder(?OrderInterface $order = null): void;

    public function getRate(): int;

    public function setRate(int $rate): void;

    public function getPublishedAt(): DateTimeInterface;

    public function setPublishedAt(DateTimeInterface $publishedAt): void;
    
    public function getReviewedAt(): DateTimeInterface;

    public function setReviewedAt(DateTimeInterface $reviewedAt): void;

    public function getReviewId(): string;

    public function setReviewId(string $reviewId): void;

    public function getContent(): string;

    public function setContent(string $content): void;

    public function getFirstname(): string;

    public function setFirstname(string $firstname): void;

    public function getLastname(): string;

    public function setLastname(string $lastname): void;
}