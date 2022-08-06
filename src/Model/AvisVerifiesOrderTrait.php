<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\Model;

trait AvisVerifiesOrderTrait
{
    /**
     * @ORM\Column(name="avis_verifies_emails_sent", type="boolean")
     */
    protected $avisVerifiesEmailsSent = false;

    /**
     * @ORM\Column(name="avis_verifies_emails_sent_at", type="datetime", nullable=true)
     */
    protected $avisVerifiesEmailsSentAt = null;

    public function getAvisVerifiesEmailsSent(): bool
    {
        return $this->avisVerifiesEmailsSent;
    }

    public function setAvisVerifiesEmailsSent(bool $avisVerifiesEmailsSent): void
    {
        $this->avisVerifiesEmailsSent = $avisVerifiesEmailsSent;

        if (true === $avisVerifiesEmailsSent) {
            $this->avisVerifiesEmailsSentAt = new \DateTime();
        }
    }

    public function getAvisVerifiesEmailsSentAt(): ?\DateTime
    {
        return $this->avisVerifiesEmailsSentAt;
    }
}
