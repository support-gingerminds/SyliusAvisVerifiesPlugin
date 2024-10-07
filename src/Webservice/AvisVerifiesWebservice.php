<?php

namespace Ikuzo\SyliusAvisVerifiesPlugin\Webservice;

use Sylius\Component\Order\Model\OrderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Product\Model\ProductInterface;

class AvisVerifiesWebservice
{
    const API_URL = 'https://www.avis-verifies.com/index.php';
    const REVIEWS_API_URL = 'https://cl.avis-verifies.com/fr/cache/';
    
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function sendOrder(OrderInterface $order): bool
    {
        $productsPayload = [];

        foreach ($order->getItems() as $item) {
            $productsPayload[] = [
                'id_product' => $item->getProduct()->getCode(),
                'name_product' => $item->getProductName()
            ];
        }
        
        $payload = [
            'query' => 'pushCommandeSHA1',
            'order_ref' => $order->getNumber(),
            'firstname' => $order->getCustomer()->getFirstname(),
            'lastname' => $order->getCustomer()->getLastname(),
            'email' => $order->getCustomer()->getEmail(),
            'order_date' => $order->getUpdatedAt()->format('Y-m-d H:i:s'),
            'delay' => $order->getChannel()->getAvisVerifiesDaysBeforeSent(),
            'PRODUCTS' => $productsPayload,
            'sign' => null
        ];

        $payload['sign'] = sha1(sprintf('%s%s%s%s%s%s%s%s',
            $payload['query'],
            $payload['order_ref'],
            $payload['email'],
            $payload['lastname'],
            $payload['firstname'],
            $payload['order_date'],
            $payload['delay'],
            $order->getChannel()->getAvisVerifiesSecretKey()
        ));

        try {
            $res = $this->client->request('POST', self::API_URL.'?action=act_api_notification_sha1&type=json2', [
                'form_params' => [
                    'idWebsite' => $order->getChannel()->getAvisVerifiesWebsiteId(),
                    'message' => json_encode($payload)
                ]
            ]);

            dd($res);
            $response = json_decode((string) $res->getBody());
    
            if ($res->getStatusCode() === 200 && $response->return === 1) {
                return true;
            }
        } catch (\Throwable $th) {
            return false;
        }

        return false;
    }

    public function fetchProductReviews(ProductInterface $product, ChannelInterface $channel): array
    {
        $path = '';
        $key = $channel->getAvisVerifiesWebsiteId();

        for ($i = 0; $i < 3; $i ++) {
            $path .= substr($key, $i, 1) . '/';
        }
        $path .= $key . '/AWS/PRODUCT_API/REVIEWS/' . $product->getCode() . '.json';

        $arrReviews = [];
        $response = $this->client->request('GET', self::REVIEWS_API_URL . $path);
        dd($response);
        $arrReviews = json_decode($response->getBody()->getContents(), true);

        return $arrReviews;
    }

}