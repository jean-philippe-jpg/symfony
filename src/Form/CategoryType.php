<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Detail;
use App\Entity\Services;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categorie')
            ->add('titre')
            ->add('description')
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',

            ])

             ->add('service_id', ChoiceType::class, [
             'choices'  => [
              #'service' => Services::class,
              'services' => Services::class,
        ],
    ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Services::class,
        ]);
    }
}
