<?php

namespace Ikuzo\SyliusAvisVerifiesPlugin\MessageHandler;

use Doctrine\ORM\EntityManagerInterface;
use Ikuzo\SyliusAvisVerifiesPlugin\Message\SendOrderToAvisVerifies;
use Ikuzo\SyliusAvisVerifiesPlugin\Webservice\AvisVerifiesWebservice;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SendOrderToAvisVerifiesHandler implements MessageHandlerInterface
{
    private OrderRepositoryInterface $orderRepository;
    private AvisVerifiesWebservice $webservice;
    private EntityManagerInterface $em;

    public function __construct(OrderRepositoryInterface $orderRepository, AvisVerifiesWebservice $webservice, EntityManagerInterface $em)
    {
        $this->orderRepository = $orderRepository;
        $this->webservice = $webservice;
        $this->em = $em;
    }

    public function __invoke(SendOrderToAvisVerifies $message)
    {
        $order = $this->orderRepository->find($message->getOrderId());
        
        if ($this->webservice->sendOrder($order)) {
            $order->setAvisVerifiesEmailsSent(true);
            $this->em->flush();
        }
    }
}