<?php

namespace App\EventListener;

use App\Entity\Product;
use App\Message\UpdateProductFromErpMessage;
use App\Message\UpdateProductFromWholesaleMessage;
use App\Message\UpdateProductMessage;
use App\Service\ErpConnectorService;
use App\Service\WholesaleService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

#[AsDoctrineListener(event: Events::postLoad, priority: 500, connection: 'default')]
class ProductEventListener {

    /**
     * Summary of __construct
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Symfony\Component\Messenger\MessageBusInterface $bus
     */
    public function __construct(
        private LoggerInterface $logger,
        private MessageBusInterface $bus,
        private ErpConnectorService $erp,
        private CacheInterface $cache,
        private WholesaleService $wholesaleService
        ) {}

    /**
     * Summary of postLoad
     * @param \Doctrine\Persistence\Event\LifecycleEventArgs $postLoad
     * @return void
     */
    public function postLoad(LifecycleEventArgs $postLoad): void
    {

        $entity = $postLoad->getObject();

        // if ($entity instanceof Product) {
        //     $itemNumber = $entity->getItemNumber();
        //     $cacheId = md5("ProductEventListener:postLoad:$itemNumber");            
        //     $this->cache->get($cacheId, function(ItemInterface $item) use ($itemNumber) {
        //         $item->expiresAfter(3600);
        //         $this->bus->dispatch(new UpdateProductMessage($itemNumber));
        //     });
        // }

    }

}