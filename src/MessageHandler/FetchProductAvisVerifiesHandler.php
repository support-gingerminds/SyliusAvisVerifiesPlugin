<?php

namespace Ikuzo\SyliusAvisVerifiesPlugin\MessageHandler;

use Doctrine\ORM\EntityManagerInterface;
use Ikuzo\SyliusAvisVerifiesPlugin\Message\FetchProductAvisVerifies;
use Ikuzo\SyliusAvisVerifiesPlugin\Webservice\AvisVerifiesWebservice;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Ikuzo\SyliusAvisVerifiesPlugin\Model\AvisVerifiesProductReviewInterface;

class FetchProductAvisVerifiesHandler implements MessageHandlerInterface
{
    private ProductRepositoryInterface $productRepository;
    private ChannelRepositoryInterface $channelRepository;
    private AvisVerifiesWebservice $webservice;
    private EntityManagerInterface $em;

    public function __construct(ProductRepositoryInterface $productRepository, ChannelRepositoryInterface $channelRepository,AvisVerifiesWebservice $webservice, EntityManagerInterface $em)
    {
        $this->productRepository = $productRepository;
        $this->channelRepository = $channelRepository;
        $this->webservice = $webservice;
        $this->em = $em;
    }

    public function __invoke(FetchProductAvisVerifies $message)
    {
        $product = $this->productRepository->findOneBy([
            'code' => $message->getProductSlug()
        ]);
        $channel = $this->channelRepository->find($message->getChannelId());
        
        foreach ($res = $this->webservice->fetchProductReviews($product, $channel) as $arr) {
            $review = $this->em->getRepository(AvisVerifiesProductReviewInterface::class)->findOneBy([
                'idSource' => $arr['id_review']
            ]);

            if ($review === null) {
                $review = $this->container->get('sylius.factory.product_review')->createNew();
                $product = $this->em->getRepository(ProductInterface::class)->findOneBy([
                    'slug' => $arr['id_product'],
                    'channel' => $channel
                ]);
                $review->setSource('avisverifies');
                $review->setIdSource($arr['id_review']);
            }
            $review->setContent($arr['review']);
            $review->setRate((int)$arr['rate']);
            $review->setLastname($arr['lastname']);
            $review->setFirstname($arr['firstname']);
            $review->setPublishedAt(new \DateTime($arr['publish_date']));
            $review->setReviewedAt(new \DateTime($arr['review_date']));
            $review->setRawSource($arr);

            $this->em->persist($review);
        }

        $this->em->flush();
    }
}