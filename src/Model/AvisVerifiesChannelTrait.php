<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\Model;

use Doctrine\ORM\Mapping as ORM;

trait AvisVerifiesChannelTrait {

    /**
     * @ORM\Column(name="avis_verifies_active", type="boolean")
     **/
    #[ORM\Column(name: 'avis_verifies_active')]
    protected bool $isAvisVerifiesActive = false;

    /**
     * @ORM\Column(name="avis_verifies_key_secret", type="string", length=255, nullable=true)
     **/
    #[ORM\Column(name: 'avis_verifies_key_secret', length: 255, nullable: true)]
    protected ?string $avisVerifiesSecretKey = null;

    /**
     * @ORM\Column(name="avis_verifies_website_id", type="string", length=255, nullable=true)
     **/
    #[ORM\Column(name: 'avis_verifies_website_id', length: 255, nullable: true)]
    protected ?string $avisVerifiesWebsiteId = null;
    
    /**
     * @ORM\Column(name="avis_verifies_days_before_sent", type="integer", nullable=false)
     **/
    #[ORM\Column(name: 'avis_verifies_days_before_sent')]
    protected ?int $avisVerifiesDaysBeforeSent = 0;

    public function getIsAvisVerifiesActive(): bool
    {
        return $this->isAvisVerifiesActive;
    }

    public function setIsAvisVerifiesActive(bool $isAvisVerifiesActive): void
    {
        $this->isAvisVerifiesActive = $isAvisVerifiesActive;
    }

    public function setAvisVerifiesSecretKey(string $avisVerifiesSecretKey): void
    {
        $this->avisVerifiesSecretKey = $avisVerifiesSecretKey;
    }

    public function getAvisVerifiesSecretKey(): ?string
    {
        return $this->avisVerifiesSecretKey;
    }
    
    public function setAvisVerifiesWebsiteId(string $avisVerifiesWebsiteId): void
    {
        $this->avisVerifiesWebsiteId = $avisVerifiesWebsiteId;
    }

    public function getAvisVerifiesWebsiteId(): ?string
    {
        return $this->avisVerifiesWebsiteId;
    }

    public function setAvisVerifiesDaysBeforeSent(int $avisVerifiesDaysBeforeSent): void
    {
        $this->avisVerifiesDaysBeforeSent = $avisVerifiesDaysBeforeSent;
    }

    public function getAvisVerifiesDaysBeforeSent(): int
    {
        return (int)$this->avisVerifiesDaysBeforeSent;
    }
}