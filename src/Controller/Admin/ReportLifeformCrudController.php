<?php

namespace App\Controller\Admin;

use App\Entity\ReportLifeform;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ReportLifeformCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ReportLifeform::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('lifeform')
            ->setCrudController(LifeformCrudController::class),
            TextareaField::new('body'),
            DateField::new('created_at')
            ->hideOnForm(),
            DateField::new('updated_at')
            ->hideOnForm(),
            AssociationField::new('author')
            ->setCrudController(UserCrudController::class)
            ->onlyOnIndex(),
        ];
    }
}
