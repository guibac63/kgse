<?php

namespace App\Controller\EventSubscriber;

use App\Entity\Admin;
use App\Entity\Agent;
use App\Entity\Contact;
use App\Entity\Country;
use App\Entity\HidingPlace;
use App\Entity\Mission;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;


class EventSubscriberPersist implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return[
            BeforeEntityPersistedEvent::class => ['setAdminId'],
        ];
    }

    public function setAdminId(BeforeEntityPersistedEvent $event)
    {
        $entInstance = $event->getEntityInstance();

        //sauvegarde l'identité de l'administrateur et la date de création
        if(!$entInstance instanceof Country && !$entInstance instanceof Admin){
            $entInstance->setAdmin($this->security->getUser());
            $entInstance->setLastUpdate(new \DateTime('now'));
            return;
        };
    }
}