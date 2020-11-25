<?php

namespace App\Form;

use App\Entity\SummaryNumbers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SummaryNumbersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nazwa'])
            ->add('numbers', NumberType::class, ['label' => 'Liczba'])
            ->add('submit', SubmitType::class, [
                'label' => 'Zapisz'
            ]);
          
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SummaryNumbers::class,
        ]);
    }
}
