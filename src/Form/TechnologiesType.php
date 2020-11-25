<?php

namespace App\Form;

use App\Entity\Technologies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TechnologiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nazwa'])
            ->add('image_path', FileType::class, [
                'data_class' => null,
                'required' => is_null($builder->getData()->getId()),
                'label' => 'Obrazek',
            ])->add('submit', SubmitType::class, [
                'label' => 'Zapisz'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Technologies::class,
        ]);
    }
}
