<?php

namespace App\Form;

use App\Entity\Equipement;
use App\Entity\Hebergement;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HebergementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('capacite')
            ->add('superficie')
            ->add('image')
            ->add('nom')
            ->add('Equipements', EntityType::class, [
                'class' => Equipement::class,
                'choice_label' => 'id',
            ])
            ->add('Types', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hebergement::class,
        ]);
    }
}
