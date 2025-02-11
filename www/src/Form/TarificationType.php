<?php

namespace App\Form;

use App\Entity\Hebergement;
use App\Entity\Saison;
use App\Entity\Tarification;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TarificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Tarif')
            ->add('date_debut', null, [
                'widget' => 'single_text',
            ])
            ->add('date_fin', null, [
                'widget' => 'single_text',
            ])
            ->add('hebergements', EntityType::class, [
                'class' => Hebergement::class,
                'choice_label' => 'id',
            ])
            ->add('Saisons', EntityType::class, [
                'class' => Saison::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tarification::class,
        ]);
    }
}
