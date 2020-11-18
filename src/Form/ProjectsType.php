<?php

namespace App\Form;

use App\Entity\Projects;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProjectsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [])
            ->add('description', TextType::class, [])
            ->add('photo_path', FileType::class, [
                'data_class' => null,
                'label' => 'Zdjęcie',
                'constraints' => [
                    'maxSize' => '5M',
                    'mimeTypes' => [
                        'image/*'
                    ],
                    'mimeTypesMessage' => 'Obsługiwany format pliku musi być obrazem'
                ]
            ]);
          
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projects::class,
        ]);
    }
}
