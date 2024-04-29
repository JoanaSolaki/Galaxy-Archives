<?php

namespace App\Form;

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

class LifeformType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class ,[
                'attr' => array(
                    'placeholder' => 'Enter the name of the lifeform.'
                )
            ])
            ->add('species', ChoiceType::class, [
                "choices" => [
                    "Aquatic" => "Aquatic",
                    "Terrestrial" => "Terrestrial",
                    "Aerial" => "Aerial"
                ]
            ])
            ->add('behavior', ChoiceType::class, [
                "choices" => [
                    "Hostile" => "Hostile",
                    "Neutral" => "Neutral",
                    "Friendly" => "Friendly"
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => array(
                    'placeholder' => 'Enter your description of your lifeform.'
                )
            ])
            ->add('planet', EntityType::class, [
                'class' => Planet::class,
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
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'maxSizeMessage' => 'The file is too large. Allowed maximum size is 2Mo.',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image (JPG, JPEG, PNG)',

                    ])
                ],
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lifeform::class,
        ]);
    }
}
