<?php

namespace App\Form;

use App\Entity\Membres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo')
            ->add('motDePasse')
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('civilité')
            ->add('statut')
            // ->add('dateEnregistrement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membres::class,
        ]);
    }
}
