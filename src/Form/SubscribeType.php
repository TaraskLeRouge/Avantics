<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SubscribeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $product = $event->getData();
            $form = $event->getForm();

            if (!$product || null === $product->getId()) {
            }
        });


        $builder
            ->add('gender', ChoiceType::class, [
                'choices' => Users::gender,
                'multiple'=>false,
                'expanded'=>true,
                'label_attr' => [
                    'class' => 'radio-inline',
                ]
            ])
            ->add('email', EmailType::class)
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('birthdate',DateType::Class, [
                'widget' => 'choice',
                'format' => 'dd/MM/yyyy',
                'years' => range(date('Y'), date('Y')-100),
            ])
            ->add('post_code', IntegerType::class)
            ->add('travel', CheckboxType::Class, [
                'required' => false,
            ])
            ->add('contest_game', CheckboxType::Class, [
                'required' => false,
            ])
            ->add('auto_moto', CheckboxType::Class, [
                'required' => false,
            ])
            ->add('shopping', CheckboxType::Class, [
                'required' => false,
            ])
            ->add('cosmetic', CheckboxType::Class, [
                'required' => false,
            ])
            ->add('insurance', CheckboxType::Class, [
                'required' => false,
            ])
            ->add('mutual_health', CheckboxType::Class, [
                'required' => false,
            ])
            ->add('optin', CheckboxType::Class, [
                'required' => true,
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
