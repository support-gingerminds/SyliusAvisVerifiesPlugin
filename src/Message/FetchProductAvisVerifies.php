<?php

namespace Ikuzo\SyliusAvisVerifiesPlugin\Message;

class FetchProductAvisVerifies
{
    private $productSlug;
    private $channelId;

    public function __construct(string $productSlug, int $channelId)
    {
        $this->productSlug = $productSlug;
        $this->channelId = $channelId;
    }

    public function getProductSlug(): string
    {
        return $this->productSlug;
    }

    public function getChannelId(): int
    {
        return $this->channelId;
    }
}