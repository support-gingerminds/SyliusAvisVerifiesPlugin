<?php

namespace Ikuzo\SyliusAvisVerifiesPlugin\MessageHandler;

use Doctrine\ORM\EntityManagerInterface;
use Ikuzo\SyliusAvisVerifiesPlugin\Message\FetchProductAvisVerifies;
use Ikuzo\SyliusAvisVerifiesPlugin\Webservice\AvisVerifiesWebservice;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Ikuzo\SyliusAvisVerifiesPlugin\Model\AvisVerifiesProductReviewInterface;
use Sylius\Component\Core\Model\Order;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

class FetchProductAvisVerifiesHandler implements MessageHandlerInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository, 
        private ChannelRepositoryInterface $channelRepository, 
        private AvisVerifiesWebservice $webservice, 
        private EntityManagerInterface $em,
        private FactoryInterface $productReviewFactory
        )
    {
    }

    public function __invoke(FetchProductAvisVerifies $message)
    {
        $product = $this->productRepository->findOneBy([
            'code' => $message->getProductSlug()
        ]);
        $channel = $this->channelRepository->find($message->getChannelId());
        
        foreach ($this->webservice->fetchProductReviews($product, $channel) as $arr) {
            $review = $this->em->getRepository(AvisVerifiesProductReviewInterface::class)->findOneBy([
                'idSource' => $arr['id_review_product']
            ]);

            if ($review === null) {
                $review = $this->productReviewFactory->createNew();
                
                $product = $this->em->getRepository(ProductInterface::class)->findOneBy([
                    'code' => $arr['id_product'],
                ]);

                $review->setReviewSubject($product);
                $review->setSource('avisverifies');
                $review->setIdSource($arr['id_review_product']);
                $review->setCreatedAt(new \DateTime($arr['review_date']));
            }

            $review->setComment($arr['review']);
            $review->setRating((int)$arr['rate']);
            $review->setRawSource($arr);
            $review->setStatus('accepted');

            $order = $this->em->getRepository(Order::class)->findOneBy([
                'number' => $arr['order_ref'],
                'channel' => $channel
            ]);

            if ($order instanceof OrderInterface) {
                $review->setAuthor($order->getCustomer());

                $this->em->persist($review);
                $this->em->flush();
            }
            
        }

    }
}