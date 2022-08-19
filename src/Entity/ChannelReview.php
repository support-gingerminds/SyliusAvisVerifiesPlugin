<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\Entity;

use DateTimeInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;

class ChannelReview implements ChannelReviewInterface
{
    use TimestampableTrait;

    /** @var int */
    protected $id;

    protected $channel;

    protected $order;

    protected $rate;

    protected $publishedAt;

    protected $reviewedAt;

    protected $reviewId;

    protected $content;

    protected $lastname;

    protected $firstname;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChannel(): ChannelInterface
    {
        return $this->channel;
    }

    public function setChannel(ChannelInterface $channel): void
    {
        $this->channel = $channel;
    }

    public function getOrder(): ?OrderInterface
    {
        return $this->order;
    }

    public function setOrder(?OrderInterface $order = null): void
    {
        $this->order = $order;
    }

    public function getRate(): int
    {
        return $this->rate;
    }

    public function setRate(int $rate): void
    {
        $this->rate = $rate;
    }

    public function getPublishedAt(): DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(DateTimeInterface $publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }
    
    public function getReviewedAt(): DateTimeInterface
    {
        return $this->reviewedAt;
    }

    public function setReviewedAt(DateTimeInterface $reviewedAt): void
    {
        $this->reviewedAt = $reviewedAt;
    }

    public function getReviewId(): string
    {
        return $this->reviewId;
    }

    public function setReviewId(string $reviewId): void
    {
        $this->reviewId = $reviewId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }
}