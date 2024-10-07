<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Ikuzo\SyliusAvisVerifiesPlugin\Entity\ChannelReview;
use Ikuzo\SyliusAvisVerifiesPlugin\Entity\ChannelReviewInterface;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Order\Model\OrderInterface;

class AvisVerifiesProcessChannelReviewsCommand extends Command
{
    const API_URL = 'https://cl.avis-verifies.com/fr/cache/';
    protected static $defaultName = 'ikuzo:avisverifies:process-channel-reviews';

    public function __construct(private HttpClientInterface $client, private EntityManagerInterface $em) {
        parent::__construct(null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $channels = $this->em->getRepository(ChannelInterface::class)->findBy([
            'enabled' => 1
        ]);
        foreach($channels as $channel) {
            if(!$channel instanceof ChannelInterface) {
                continue;
            }
            $secretKey = $channel->getAvisVerifiesWebsiteId();
            if(in_array($secretKey, ['', null])) {
                continue;
            }
            
            $path = $this->parseKeyToPath($secretKey);
            
            try {
                $res = $this->fetchChannelReviews($path);
                $this->cycleReviews($channel, $res);
            } catch (\Exception $ex) {
                // dd($ex);
            } catch (\Throwable $ex) {
                // dd($ex);
            }
        }

        $this->em->flush();

        return Command::SUCCESS;
    }

    protected function parseKeyToPath(string $key): string
    {
        $result = '';
        for ($i = 0; $i < 3; $i ++) {
            $result .= substr($key, $i, 1) . '/';
        }
        return $result . $key . '/AWS/WEBSITE_API/reviews.json';
    }

    protected function fetchChannelReviews(string $path): array
    {
        $res = [];

        $response = $this->client->request('GET', self::API_URL . $path);
        $res = json_decode($response->getBody()->getContents(), true);
        return $res ?? [];
    }

    protected function cycleReviews(ChannelInterface $channel, array $reviews): void
    {
        foreach ($reviews as $arr) {
            $review = $this->em->getRepository(ChannelReviewInterface::class)->findOneBy([
                'reviewId' => $arr['id_review'],
                'channel' => $channel
            ]);

            if ($review === null) {
                $review = new ChannelReview();

                $order = $this->em->getRepository(OrderInterface::class)->findOneBy([
                    'number' => $arr['order_ref'],
                    'channel' => $channel
                ]);
                $review->setChannel($channel);
                $review->setOrder($order);
                $review->setReviewId($arr['id_review']);
            }

            $review->setContent($arr['review']);
            $review->setRate((int)$arr['rate']);
            $review->setLastname($arr['lastname']);
            $review->setFirstname($arr['firstname']);
            $review->setPublishedAt(new \DateTime($arr['publish_date']));
            $review->setReviewedAt(new \DateTime($arr['review_date']));

            $this->em->persist($review);
        }
    }
}
