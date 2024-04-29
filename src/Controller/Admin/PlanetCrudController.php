<?php

namespace App\Controller\Admin;

use App\Entity\Planet;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PlanetCrudController extends AbstractCrudController implements EventSubscriberInterface
{
    public static function getEntityFqcn(): string
    {
        return Planet::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            ChoiceField::new('type')
            ->setChoices([
                "Exoplanet" => "Exoplanet",
                "Gas planet" => "Gas planet",
                "Lava planet" => "Lava planet",
                "Ice planet" => "Ice planet",
                "Iron planet" => "Iron planet",
                "Helium planet" => "Helium planet",
                "Chthonian planet" => "Chthonian planet"
            ])
            ->renderAsBadges(),
            ChoiceField::new('life_condition')
            ->setChoices([
                "Hostile" => "Hostile",
                "Neutral" => "Neutral",
                "Livable" => "Livable"
            ]),
            TextEditorField::new('description'),
            DateField::new('created_at')
            ->hideOnForm(),
            DateField::new('updated_at')
            ->hideOnForm(),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('imageName')
                ->setBasePath('/uploads/images/planets')
                ->setUploadDir('/public')
                ->onlyOnIndex(),
            AssociationField::new('galaxy')
            ->setCrudController(GalaxyCrudController::class),
            AssociationField::new('lifeforms')
            ->setCrudController(LifeformCrudController::class)
            ->onlyOnForms(),
            AssociationField::new('author')
            ->setCrudController(UserCrudController::class)
            ->onlyOnIndex(),
        ];
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ["beforePersist"],
            BeforeEntityUpdatedEvent::class => ["beforeUpdate"]
        ];
    }

    public function beforePersist (BeforeEntityPersistedEvent $event) {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Planet) {
            $entity->setCreatedAt(new DateTime());
        }
    }

    public function beforeUpdate (BeforeEntityUpdatedEvent $event) {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Planet) {
            $entity->setUpdatedAt(new DateTime());
        }
    }
}
