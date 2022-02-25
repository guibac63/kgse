<?php

namespace App\Controller\Admin;

use App\Entity\Agent;
use App\Entity\Mission;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Exception\ForbiddenActionException;
use EasyCorp\Bundle\EasyAdminBundle\Exception\InsufficientEntityPermissionException;
use EasyCorp\Bundle\EasyAdminBundle\Factory\EntityFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Security\Permission;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MissionCrudController extends AbstractCrudController
{
    public function __construct(private SessionInterface $session)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Mission::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('description'),
            TextField::new('code_name'),
            ChoiceField::new('category')->setChoices(['Surveillance'=>'SURVEILLANCE','Infiltration'=>'INFILTRATION','Vol'=>'VOL','Protection'=>'PROTECTION','Neutralisation de cible'=>'NEUTRALISATION DE CIBLE']),
            ChoiceField::new('status')->setChoices(['En préparation'=>'EN PREPARATION','En cours'=>'EN COURS','Terminée'=>'TERMINEE','Echec'=>'ECHEC']),
            DateField::new('beginning_date'),
            DateField::new('ending_date'),
            AssociationField::new('country')->setFormTypeOption('required',true),
            AssociationField::new('hidingplace'),
            AssociationField::new('agent')->setFormTypeOption('required',true),
            AssociationField::new('skills'),
            AssociationField::new('contact')->setFormTypeOption('required',true),
            AssociationField::new('target')->setFormTypeOption('required',true),
            IdField::new('admin')->hideOnForm(),
            DateTimeField::new('last_update')->hideOnForm(),
        ];
    }

    public function new(AdminContext $context)
    {
        $event = new BeforeCrudActionEvent($context);
        $this->container->get('event_dispatcher')->dispatch($event);
        if ($event->isPropagationStopped()) {
            return $event->getResponse();
        }

        if (!$this->isGranted(Permission::EA_EXECUTE_ACTION, ['action' => Action::NEW, 'entity' => null])) {
            throw new ForbiddenActionException($context);
        }

        if (!$context->getEntity()->isAccessible()) {
            throw new InsufficientEntityPermissionException($context);
        }

        $context->getEntity()->setInstance($this->createEntity($context->getEntity()->getFqcn()));
        $this->container->get(EntityFactory::class)->processFields($context->getEntity(), FieldCollection::new($this->configureFields(Crud::PAGE_NEW)));
        $context->getCrud()->setFieldAssets($this->getFieldAssets($context->getEntity()->getFields()));
        $this->container->get(EntityFactory::class)->processActions($context->getEntity(), $context->getCrud()->getActionsConfig());

        $newForm = $this->createNewForm($context->getEntity(), $context->getCrud()->getNewFormOptions(), $context);
        $newForm->handleRequest($context->getRequest());

        $entityInstance = $newForm->getData();
        $context->getEntity()->setInstance($entityInstance);

        if ($newForm->isSubmitted() && $newForm->isValid()) {
            $this->processUploadedFiles($newForm);

            $event = new BeforeEntityPersistedEvent($entityInstance);
            $this->container->get('event_dispatcher')->dispatch($event);
            $entityInstance = $event->getEntityInstance();
            /////////////////////////////////////////////////////////////
            //implements workflow logic

            //date logic verification
            $missionBeginningDate=$entityInstance->getBeginningDate();
            $missionEndingDate=$entityInstance->getEndingDate();

            //country verification
            $agentsCountry = [];
            $hidingPlacesCountry = [];
            $contactsCountry = [];
            $targetsCountry = [];
            if ($entityInstance->getCountry()!==null){
                $missionCountry = $entityInstance->getCountry()->getId();
            }

            //get all the coutries id of the agents
            $agents = $entityInstance->getAgent()->getValues();
            foreach($agents as $agent){
                $agentsCountry[] = $agent->getCountry()->getId();
            };

            //get all the coutries id of the targets
            $targets = $entityInstance->getTarget()->getValues();
            foreach($targets as $target){
                $targetsCountry[] = $target->getCountry()->getId();
            };

            //get all the coutries id of the contacts
            $contacts = $entityInstance->getContact()->getValues();
            foreach($contacts as $contact){
                $contactsCountry[] = $contact->getCountry()->getId();
            };

            //get all the coutries id of the hiding_places
            $hidingPlaces = $entityInstance->getHidingplace()->getValues();
            foreach($hidingPlaces as $hidingPlace){
                $hidingPlacesCountry[] = $hidingPlace->getCountry()->getId();
            };

            //skills verification
            $agentsSkills = [];
            $missionSkill = $entityInstance->getSkills()->getId();

            //get all the skills id of all the agents
            foreach($agents as $agent){
                $agent_skills = $agent->getAgentSkills();
                foreach ($agent_skills as $skill){
                    $agentsSkills[]= $skill->getId();
                }
            };

            //compare if a value is always === to all the values of an array
            function array_every($value,$array){
                foreach ($array as $elt){
                    if ($value !== $elt) return false;
                }
                return true;
            }

            //compare if a value is always === to all the values of an array
            function array_any($value,$array){
                foreach ($array as $elt){
                    if ($value === $elt) return true;
                }
                return false;
            }

            //persist validation :
            $validation = true;

            //if the mission country is not set
            if(!isset($missionCountry)){
                $this->session->getFlashbag('')->add('danger','Veuillez renseigner un pays pour la mission');
                $validation=false;
            //if one of the target has the same nationality of one of the agents
            }elseif (array_intersect($targetsCountry,$agentsCountry)){
                $this->session->getFlashbag('')->add('danger','La nationalité des cibles ne peut pas être la même que celle des agents');
                $validation=false;
            //if all the contacts have not the same country of mission
            }elseif (!array_every($missionCountry,$contactsCountry)){
                $this->session->getFlashbag('')->add('danger','La nationalité des contacts doit être la même que le pays de la mission');
                $validation=false;
            //if all the hiding places have not the same mission country
            }elseif(!array_every($missionCountry,$hidingPlacesCountry)){
                $this->session->getFlashbag('')->add('danger','Le pays des planques doit être le même que le pays de la mission');
                $validation=false;
            //if one of the agent skills not match with the required mission skill
            }elseif(!array_any($missionSkill,$agentsSkills)){
                $this->session->getFlashbag('')->add('danger','La compétence requise pour la mission doit être maitrisée par au moins un des agents');
                $validation=false;
                //beginning date must be before ending date
            }elseif ($missionBeginningDate>$missionEndingDate){
                $this->session->getFlashbag('')->add('danger','La date de départ de la mission doit être inférieure à la date de fin');
                $validation=false;
            }

            if($validation){
                //dd($hidingPlacesCountry,$agentsCountry,$targetsCountry,$contactsCountry,$missionCountry,$missionSkill,$agentsSkills);

                $this->persistEntity($this->container->get('doctrine')->getManagerForClass($context->getEntity()->getFqcn()), $entityInstance);

                $this->container->get('event_dispatcher')->dispatch(new AfterEntityPersistedEvent($entityInstance));
                $context->getEntity()->setInstance($entityInstance);

                return $this->getRedirectResponseAfterSave($context, Action::NEW);
            }

        }
        /////////////////////////////////////////////////////////////
       $responseParameters = $this->configureResponseParameters(KeyValueStore::new([
           'pageName' => Crud::PAGE_NEW,
          'templateName' => 'crud/new',
           'entity' => $context->getEntity(),
            'new_form' => $newForm,
        ]));

        $event = new AfterCrudActionEvent($context, $responseParameters);
        $this->container->get('event_dispatcher')->dispatch($event);
        if ($event->isPropagationStopped()) {
            return $event->getResponse();
        }

        return $responseParameters;
    }

}
