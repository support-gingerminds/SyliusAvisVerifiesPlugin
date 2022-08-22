<?php

declare(strict_types=1);

namespace Tests\Ikuzo\SyliusAvisVerifiesPlugin\Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ikuzo\SyliusAvisVerifiesPlugin\Model\AvisVerifiesProductReviewTrait;
use Ikuzo\SyliusAvisVerifiesPlugin\Model\AvisVerifiesProductReviewInterface;
use Sylius\Component\Core\Model\ProductReview as BaseProductReview;

/**
 * @ORM\Table(name="sylius_product_review")
 * @ORM\Entity()
 */
class ProductReview extends BaseProductReview implements AvisVerifiesProductReviewInterface
{
    use AvisVerifiesProductReviewTrait;
}