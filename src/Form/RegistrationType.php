<?php

namespace App\Form;

use App\Entity\People;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, [
                'help' => 'email@something.else required',
                'validation_groups' => ['Default'],
            ])
            ->add('password', Type\PasswordType::class, [
                'help' => 'strong password recommanded',
                'validation_groups' => ['Default'],
            ])
            ->add('nickname', Type\TextType::class, [
                'help' => 'this is optional',
                'required' => false,
            ])
            ->add('eula', Type\CheckboxType::class, [
                'label' => '<b>Je certifie que je suis d\'accord!</b>',
                'label_html' => true,
                'mapped' => false,
            ])
            ->add('register', Type\SubmitType::class, [
                'label' => 'Register',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => People::class,
        ]);
    }
}
