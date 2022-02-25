<?php

namespace App\Controller\EventSubscriber;

use App\Entity\Admin;
use App\Entity\Agent;
use App\Entity\Contact;
use App\Entity\Country;
use App\Entity\HidingPlace;
use App\Entity\Mission;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use EasyCorp\Bundle\EasyAdminBundle\Event\StoppableEventTrait;


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
            BeforeEntityUpdatedEvent::class=> ['updateAdminId'],
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

    public function updateAdminId(BeforeEntityUpdatedEvent $event)
    {
        $entInstance = $event->getEntityInstance();

        //sauvegarde l'identité de l'administrateur et la date de modification
        if(!$entInstance instanceof Country && !$entInstance instanceof Admin){
            $entInstance->setAdmin($this->security->getUser());
            $entInstance->setLastUpdate(new \DateTime('now'));
            return;
        };
    }




}