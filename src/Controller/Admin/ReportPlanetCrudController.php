<?php

namespace App\Controller\Admin;

use App\Entity\ReportPlanet;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ReportPlanetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ReportPlanet::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('planet')
            ->setCrudController(PlanetCrudController::class),
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
