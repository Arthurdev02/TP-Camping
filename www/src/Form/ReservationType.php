<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Statut;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_arrive', null, [
                'widget' => 'single_text',
            ])
            ->add('date_depart', null, [
                'widget' => 'single_text',
            ])
            ->add('nombre_personne')
            ->add('Status', EntityType::class, [
                'class' => Statut::class,
                'choice_label' => 'id',
            ])
            ->add('Users', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
