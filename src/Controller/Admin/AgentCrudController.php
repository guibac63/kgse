<?php

namespace App\Controller\Admin;

use App\Entity\Agent;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AgentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Agent::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('firstname'),
            TextField::new('lastname'),
            ImageField::new('avatar')
                ->setBasePath("/public/images")
                ->setUploadDir("/public/images")
                ->setSortable(false),
            DateTimeField::new('birth_date'),
            DateTimeField::new('last_update')->hideOnForm(),
            AssociationField::new('agent_skills'),
            AssociationField::new('country'),
            AssociationField::new('mission_agent'),
            //ChoiceField::new('mission')->setChoices(['karate'=>'karate','kungfu'=>'kungfu']),


            //TextEditorField::new('description'),
        ];
    }

}
