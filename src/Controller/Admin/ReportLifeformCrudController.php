<?php

namespace App\Controller\Admin;

use App\Entity\ReportLifeform;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ReportLifeformCrudController extends AbstractCrudController implements EventSubscriberInterface
{
    public static function getEntityFqcn(): string
    {
        return ReportLifeform::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('lifeform')
            ->setCrudController(LifeformCrudController::class)
            ->setRequired(true),
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

        if ($entity instanceof ReportLifeform) {
            $entity->setCreatedAt(new DateTime());
            $entity->setAuthor($this->getUser());
        }
    }

    public function beforeUpdate (BeforeEntityUpdatedEvent $event) {
        $entity = $event->getEntityInstance();

        if ($entity instanceof ReportLifeform) {
            $entity->setUpdatedAt(new DateTime());
        }
    }
}
