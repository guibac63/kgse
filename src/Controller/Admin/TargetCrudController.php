<?php

namespace App\Controller\Admin;

use App\Entity\Skills;
use App\Entity\Target;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TargetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Target::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('firstname'),
            TextField::new('lastname'),
            TextField::new('code_name'),
            DateField::new('birth_date'),
            DateTimeField::new('last_update')->hideOnForm(),
            AssociationField::new('mission')->setFormTypeOption('required',true),
            AssociationField::new('country'),
            IdField::new('admin')->hideOnForm()
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Target) return;
        $entityInstance->setLastUpdate(new \DateTime('now'));
        parent::persistEntity($entityManager,$entityInstance);
    }
}
