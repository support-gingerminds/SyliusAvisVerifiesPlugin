<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Ikuzo\SyliusAvisVerifiesPlugin\Message\FetchProductAvisVerifies;
use Sylius\Component\Channel\Model\ChannelInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class AvisVerifiesProcessProductReviewsCommand extends Command
{
    const API_URL = 'https://cl.avis-verifies.com/fr/cache/';
    protected static $defaultName = 'ikuzo:avisverifies:process-product-reviews';

    // /AWS/PRODUCT_API/REVIEWS/files_list.txt

    public function __construct(private HttpClientInterface $client, private EntityManagerInterface $em, private MessageBusInterface $bus) {
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
                $res = $this->fetchProducts($path);
                $this->cycleReviews($channel, $res);
            } catch (\Exception $ex) {
                dd($ex);
            } catch (\Throwable $ex) {
                dd($ex);
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
        return $result . $key . '/AWS/PRODUCT_API/REVIEWS/files_list.txt';
    }

    protected function fetchProducts(string $path): array
    {
        $csv = file_get_contents(self::API_URL . $path);
        dd($csv);
        $lines = explode(PHP_EOL, $csv);
        $data = [];
        foreach ($lines as $line) {
            $data[] = str_getcsv($line, ';');
        }
        return $data ?? [];
    }

    protected function cycleReviews(ChannelInterface $channel, array $reviews): void
    {
        foreach ($reviews as $review) {
            $this->bus->dispatch(new FetchProductAvisVerifies($review[0], $channel->getId()));
        }
    }
}
