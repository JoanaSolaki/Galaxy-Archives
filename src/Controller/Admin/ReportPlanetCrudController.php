<?php

namespace App\Controller\Admin;

use App\Entity\ReportPlanet;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ReportPlanetCrudController extends AbstractCrudController implements EventSubscriberInterface
{
    public static function getEntityFqcn(): string
    {
        return ReportPlanet::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('planet')
            ->setCrudController(PlanetCrudController::class)            ->setRequired(true),
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

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ["beforePersist"],
            BeforeEntityUpdatedEvent::class => ["beforeUpdate"]
        ];
    }

    public function beforePersist (BeforeEntityPersistedEvent $event) {
        $entity = $event->getEntityInstance();

        if ($entity instanceof ReportPlanet) {
            $entity->setCreatedAt(new DateTime());
            $entity->setAuthor($this->getUser());
        }
    }

    public function beforeUpdate (BeforeEntityUpdatedEvent $event) {
        $entity = $event->getEntityInstance();

        if ($entity instanceof ReportPlanet) {
            $entity->setUpdatedAt(new DateTime());
        }
    }
}
