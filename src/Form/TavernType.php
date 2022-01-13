<?php

namespace App\Form;

use App\Entity\Tavern;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;

class TavernType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', Type\TextType::class)
            ->add('address', AddressType::class)
            ->add('addedBy', PeopleType::class, [
                'label' => false,
                'disabled'=> true,
            ])
            ->add('add', Type\SubmitType::class, [
                'label' => 'Add a new tavern!'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tavern::class,
        ]);
    }
}
