<?php

namespace App\Form;

use App\Entity\About;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AboutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rotate', TextType::class, ['label' => 'Elemet Rotate'])
            ->add('description', TextType::class, ['label' => 'Opis'])
            ->add('name', TextType::class, ['label' => 'Imię i nazwisko'])
            ->add('birth', BirthdayType::class, ['format' => 'dd-MM-yyyy', 'label' => 'Data urodzin'])
            ->add('address', TextType::class, ['label' => 'Adres'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('phone', TelType::class, ['label' => 'Nr telefonu'])
            ->add('projects', NumberType::class, ['label' => 'Liczna projektów'])
            ->add('fileNamePhoto', FileType::class, [
                'data_class' => null,
                'required' => is_null($builder->getData()->getId()),
                'multiple' => false,
                'label' => 'Zdjęcie główne'
            ])
            ->add('fileNameCv', FileType::class, [
                'data_class' => null,
                'required' => is_null($builder->getData()->getId()),
                'multiple' => false,
                'label' => 'CV'
            ])->add('submit', SubmitType::class, [
                'label' => 'Zapisz'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => About::class,
        ]);
    }
}
