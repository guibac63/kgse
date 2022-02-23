<?php

namespace App\Controller\Admin;

use App\Entity\HidingPlace;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HidingPlaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HidingPlace::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('address'),
            ChoiceField::new('type')->setChoices(['Hôtel'=>'HOTEL','Appartement'=>'APPARTEMENT','Villa'=>'VILLA','Châlet'=>'CHALET','Centre militaire'=>'CENTRE MILITAIRE']),
            DateTimeField::new('last_update')->hideOnForm(),
            AssociationField::new('country'),
            AssociationField::new('missions')->setDisabled(),
            IdField::new('admin')->hideOnForm()
        ];
    }

}
