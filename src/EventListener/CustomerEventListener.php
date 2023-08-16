<?php

namespace App\EventListener;

use App\Entity\Customer;
use App\Message\UpdateCustomerFromErpMessage;
use App\Service\ErpConnectorService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

#[AsDoctrineListener(event: Events::postLoad, priority: 500, connection: 'default')]
class CustomerEventListener {

    /**
     * Summary of __construct
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Symfony\Component\Messenger\MessageBusInterface $bus
     */
    public function __construct(
        private LoggerInterface $logger,
        private MessageBusInterface $bus,
        private ErpConnectorService $erp,
        private CacheInterface $cache
        ) {}

    /**
     * Summary of postLoad
     * @param \Doctrine\Persistence\Event\LifecycleEventArgs $postLoad
     * @return void
     */
    public function postLoad(LifecycleEventArgs $postLoad): void
    {
        $entity = $postLoad->getObject();

        if ($entity instanceof Customer) {
            $customerNumber = $entity->getCustomerNumber();
            $cacheId = md5("CustomerEventListener:postLoad:$customerNumber");
            $this->cache->get($cacheId, function(ItemInterface $item) use ($customerNumber) {
                $item->expiresAfter(3900);
                $customer = $this->erp->getCustomer($customerNumber);
                $this->logger->info("Updating customer " . $customerNumber . " from ERP");
                $this->bus->dispatch(new UpdateCustomerFromErpMessage($customer));
            });
        }
    }

}