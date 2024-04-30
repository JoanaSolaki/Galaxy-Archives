<?php

namespace App\Form;

use App\Entity\Galaxy;
use App\Entity\Lifeform;
use App\Entity\Planet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

class PlanetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class ,[
                'attr' => array(
                    'placeholder' => 'Enter the name of the planet.'
                )
            ])
            ->add('type', ChoiceType::class, [
                "choices" => [
                    "Exoplanet" => "Exoplanet",
                    "Gas planet" => "Gas planet",
                    "Lava planet" => "Lava planet",
                    "Ice planet" => "Ice planet",
                    "Iron planet" => "Iron planet",
                    "Helium planet" => "Helium planet",
                    "Chthonian planet" => "Chthonian planet"
                ]
            ])
            ->add('lifeCondition', ChoiceType::class, [
                "choices" => [
                    "Hostile" => "Hostile",
                    "Neutral" => "Neutral",
                    "Livable" => "Livable"
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => array(
                    'placeholder' => 'Enter your description of your planet.'
                )
            ])
            ->add('galaxy', EntityType::class, [
                'class' => Galaxy::class,
                'choice_label' => 'name',
            ])
            ->add('lifeforms', EntityType::class, [
                'class' => Lifeform::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Remove image',
                'download_uri' => false,
                // 'image_uri' => true,
                // 'imagine_pattern' => '...',
                'asset_helper' => true,
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Planet::class,
        ]);
    }
}
