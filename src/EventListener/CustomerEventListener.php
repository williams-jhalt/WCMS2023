<?php

namespace App\EventListener;

use App\Entity\Customer;
use App\Message\UpdateCustomerFromErpMessage;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsDoctrineListener(event: Events::postLoad, priority: 500, connection: 'default')]
class CustomerEventListener {

    /**
     * Summary of __construct
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Symfony\Component\Messenger\MessageBusInterface $bus
     */
    public function __construct(
        private LoggerInterface $logger,
        private MessageBusInterface $bus
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
            $this->logger->info("Updating customer " . $customerNumber . " from ERP");
            $this->bus->dispatch(new UpdateCustomerFromErpMessage($customerNumber));
        }
    }

}