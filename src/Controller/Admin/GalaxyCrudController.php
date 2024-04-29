<?php

namespace App\Controller\Admin;

use App\Entity\Galaxy;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class GalaxyCrudController extends AbstractCrudController implements EventSubscriberInterface
{
    public static function getEntityFqcn(): string
    {
        return Galaxy::class;
    }

    // public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    // {
    //     $entityInstance->setUpdatedAt(new \DateTime());

    //     parent::updateEntity($entityManager, $entityInstance);
    // }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextareaField::new('particularities'),
            TextareaField::new('description'),
            DateField::new('created_at')
            ->hideOnForm(),
            DateField::new('updated_at')
            ->hideOnForm(),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('imageName')
                ->setBasePath('/uploads/images/galaxy')
                ->setUploadDir('/public')
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

        if ($entity instanceof Galaxy) {
            $entity->setCreatedAt(new DateTime());
        }
    }

    public function beforeUpdate (BeforeEntityUpdatedEvent $event) {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Galaxy) {
            $entity->setUpdatedAt(new DateTime());
        }
    }
}
