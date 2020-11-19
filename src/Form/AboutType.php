<?php

namespace App\Form;

use App\Entity\About;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class AboutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rotate', TextType::class, [])
            ->add('description', TextType::class, [])
            ->add('name', TextType::class, [])
            ->add('birth', BirthdayType::class, ['format' => 'dd-MM-yyyy'])
            ->add('address', TextType::class, [])
            ->add('email', EmailType::class, [])
            ->add('phone', TelType::class, [])
            ->add('projects', NumberType::class, [])
            ->add('fileNamePhoto', FileType::class, [
                'multiple' => false,
                'mapped' => false,
                'label' => 'Zdjęcie główne',
                'constraints' => [
                    'maxSize' => '5M',
                    'mimeTypes' => [
                        'image/*'
                    ],
                    'mimeTypesMessage' => 'Obsługiwany format pliku musi być obrazem'
                ]
            ])
            ->add('fileNameCv', FileType::class, [
                'multiple' => true,
                'mapped' => false,
                'label' => 'CV',
                'constraints' => [
                    'maxSize' => '5M',
                    'mimeTypes' => [
                        'application/pdf'
                    ],
                    'mimeTypesMessage' => 'Obsługiwany format pliku musi być pdf'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => About::class,
        ]);
    }
}
