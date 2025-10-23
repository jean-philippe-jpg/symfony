<?php

namespace App\Form;

use Dom\Entity;
use BcMath\Number;
use App\Entity\Detail;
use Doctrine\ORM\EntityRepository;
use App\Repository\DetailRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\DoctrineType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Pseudo',
            ])
            ->add('message',  TextareaType::class, [
                'label' => 'Message',
            ])

            ->add('details', EntityType::class, [
                'class' => Detail::class,
               'query_builder' => function (EntityRepository $er) {
                   return $er->createQueryBuilder('d')
                       ->orderBy('d.id', 'ASC');
               },
            ])


          ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',

            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
