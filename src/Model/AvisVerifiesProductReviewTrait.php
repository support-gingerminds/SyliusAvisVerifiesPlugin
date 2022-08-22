<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\Model;

trait AvisVerifiesProductReviewTrait
{
    /**
     * @ORM\Column(name="source", type="string", nullable=true)
     */
    protected $source;

    /**
     * @ORM\Column(name="source_id", type="string", nullable=true)
     */
    protected $idSource;

    /**
     * @ORM\Column(name="source_raw", type="array", nullable=true)
     */
    protected $rawSource;

    public function getSource(): string
    {
        if ($this->source === null) {
            return 'website';
        }

        return $this->source;
    }

    public function setSource(?string $source): void
    {
        $this->source = $source;
    }

    public function getIdSource(): ?string
    {
        return $this->idSource;
    }

    public function setIdSource(?string $idSource): void
    {
        $this->idSource = $idSource;
    }

    public function getRawSource(): ?array
    {
        return $this->rawSource;
    }

    public function setRawSource(?array $rawSource): void
    {
        $this->rawSource = $rawSource;
    }
}