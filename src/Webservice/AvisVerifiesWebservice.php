<?php

namespace Ikuzo\SyliusAvisVerifiesPlugin\Webservice;

use Sylius\Component\Order\Model\OrderInterface;
use GuzzleHttp\ClientInterface;

class AvisVerifiesWebservice
{
    const API_URL = 'https://www.avis-verifies.com/index.php';
    
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
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
            'delay' => '0',
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
    
            $response = json_decode((string) $res->getBody());
    
            if ($res->getStatusCode() === 200 && $response->return === 1) {
                return true;
            }
        } catch (\Throwable $th) {
            return false;
        }

        return false;
    }

}