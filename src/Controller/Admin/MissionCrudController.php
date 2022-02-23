<?php

namespace App\Controller\Admin;

use App\Entity\Mission;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MissionCrudController extends AbstractCrudController
{
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
            AssociationField::new('target')->setDisabled(),
            IdField::new('admin')->hideOnForm(),
            DateTimeField::new('last_update')->hideOnForm(),
        ];
    }

}
