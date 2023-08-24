<?php

namespace App\EventSubscriber;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['encryptUserPassword']
        ];
    }

    public function encryptUserPassword(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof User) {
            $entity->setPassword(
                $this->hasher->hashPassword($entity, $entity->getPassword())
            );
        }
    }
}