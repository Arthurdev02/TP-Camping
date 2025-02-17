<?php

namespace App\Form;

use App\Entity\Accomodation;
use App\Entity\Equipement;
use App\Entity\Tarification;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccomodationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('nbreBedrooms')
            ->add('isAvaliable')
            ->add('imagePath')
            ->add('Size')
            ->add('Equipements', EntityType::class, [
                'class' => Equipement::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('tarifications', EntityType::class, [
                'class' => Tarification::class,
                'choice_label' => 'price',
            ])
            ->add('types', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'label',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Accomodation::class,
        ]);
    }
}
