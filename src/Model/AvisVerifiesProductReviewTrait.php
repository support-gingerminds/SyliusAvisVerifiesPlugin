<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\Model;

use Sylius\Component\Core\Model\Customer;
use Sylius\Component\Review\Model\ReviewerInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait AvisVerifiesProductReviewTrait
{
    /**
     * @ORM\Column(name="source", type="string", nullable=true)
     */
    #[ORM\Column(name: 'source', nullable: true)]
    protected ?string $source;

    /**
     * @ORM\Column(name="source_id", type="string", nullable=true)
     */
    #[ORM\Column(name: 'source_id', nullable: true)]
    protected ?string $idSource;

    /**
     * @ORM\Column(name="source_raw", type="array", nullable=true)
     */
    #[ORM\Column(name: 'source_raw', type: Types::SIMPLE_ARRAY, nullable: true)]
    protected ?array $rawSource;

    public function getSource(): string
    {
        if ($this->source === null) {
            return 'sylius';
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