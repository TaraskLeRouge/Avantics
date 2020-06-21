<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('lastname')
            ->add('firstname')
            ->add('gender')
            ->add('birthdate')
            ->add('post_code')
            ->add('travel')
            ->add('contest_game')
            ->add('auto_moto')
            ->add('shopping')
            ->add('cosmetic')
            ->add('insurance')
            ->add('mutual_health')
            ->add('optin')
            ->add('optin_date')
            ->add('optin_ip')
            ->add('unsubscripe_date')
            ->add('unsubscripe_ip')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
