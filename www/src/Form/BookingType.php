<?php

namespace App\Form;

use App\Entity\Accomodation;
use App\Entity\Booking;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_start', null, [
                'widget' => 'single_text',
            ])
            ->add('date_end', null, [
                'widget' => 'single_text',
            ])
            ->add('nbre_adults')
            ->add('nbre_childrens')
            ->add('users', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('Accomodations', EntityType::class, [
                'class' => Accomodation::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
