<?php

namespace App\Form;

use App\Entity\Lifeform;
use App\Entity\ReportLifeform;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportLifeformType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('body')
            ->add('created_at', null, [
                'widget' => 'single_text',
            ])
            ->add('update_at', null, [
                'widget' => 'single_text',
            ])
            ->add('lifeform', EntityType::class, [
                'class' => Lifeform::class,
                'choice_label' => 'id',
            ])
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReportLifeform::class,
        ]);
    }
}
