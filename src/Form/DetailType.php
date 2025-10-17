<?php

namespace App\Form;

use App\Entity\Detail;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('tarif')
            ->add('categorie', EntityType::class, [
             'class' => Category::class,
                'choice_label' => 'titre',

         ])
         ->add('filename', FileType::class, [
             'label' => 'Image (JPEG or PNG file)',
             'mapped' => false,
             'required' => false,
             'constraints' => [
                 new Image()
                ],
            ])

              ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
              ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Detail::class,
        ]);
    }
}
