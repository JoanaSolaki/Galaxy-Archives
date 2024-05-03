<?php

namespace App\Controller\Admin;

use App\Entity\Lifeform;
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

class LifeformCrudController extends AbstractCrudController implements EventSubscriberInterface
{
    public static function getEntityFqcn(): string
    {
        return Lifeform::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            ChoiceField::new('species')
            ->setChoices([
                "Aquatic" => "Aquatic",
                "Terrestrial" => "Terrestrial",
                "Aerial" => "Aerial"
            ])
            ->renderAsBadges()
            ->setRequired(true),
            ChoiceField::new('behavior')
            ->setChoices([
                "Hostile" => "Hostile",
                "Neutral" => "Neutral",
                "Friendly" => "Friendly"
            ])
            ->renderAsBadges(),
            TextareaField::new('description'),
            DateField::new('created_at')
            ->hideOnForm(),
            DateField::new('updated_at')
            ->hideOnForm(),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            AssociationField::new('planet')
            ->setCrudController(PlanetCrudController::class)
            ->onlyOnForms()
            ->setRequired(true),
            AssociationField::new('author')
            ->setCrudController(UserCrudController::class)
            ->onlyOnIndex(),
            ImageField::new('imageName')
            ->setBasePath('/uploads/images/lifeform')
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

        if ($entity instanceof Lifeform) {
            $entity->setCreatedAt(new DateTime());
            $entity->setAuthor($this->getUser());
        }
    }

    public function beforeUpdate (BeforeEntityUpdatedEvent $event) {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Lifeform) {
            $entity->setUpdatedAt(new DateTime());
        }
    }
}
