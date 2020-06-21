<?php

namespace App\Form;

use App\Entity\Campaigns;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampaignsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('creation_user_id')
            ->add('creation_date')
            ->add('registration_name_button')
            ->add('thumbnailImageFilename')
            ->add('lanscapeImageFilename')
            ->add('start_date')
            ->add('stop_date')
            ->add('actif')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Campaigns::class,
        ]);
    }
}
