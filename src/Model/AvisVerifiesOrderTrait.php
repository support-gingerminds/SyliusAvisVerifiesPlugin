<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\Model;

use Doctrine\ORM\Mapping as ORM;

trait AvisVerifiesOrderTrait
{
    /**
     * @ORM\Column(name="avis_verifies_emails_sent", type="boolean")
     */
    #[ORM\Column(name: 'avis_verifies_emails_sent')]
    protected bool $avisVerifiesEmailsSent = false;

    /**
     * @ORM\Column(name="avis_verifies_emails_sent_at", type="datetime", nullable=true)
     */
    #[ORM\Column(name: 'avis_verifies_emails_sent_at', nullable: true)]
    protected ?\DateTime $avisVerifiesEmailsSentAt = null;

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
