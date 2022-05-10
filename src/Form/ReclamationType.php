<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeRec',ChoiceType::class, [
        'choices'  => [
            'Réservation' => 'Réservation',
            'Financier' => 'Financier',
            'Autre' => 'Autre',
        ],
    ])


        ->add('descriptionRec')

            ->add('dateRec', DateType::class, [
                'widget' => "single_text"


            ])
            ->add('cin')
           // ->add('archived')
            ->add('screenshot', FileType::class, [
               'label'=>false,
               'multiple'=> false,
               'mapped'=>false,
               'required' => false
            ])
            ->add('email')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
