<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\DataTransformer\CityNameTransformer;
use App\Form\DTO\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PickupPointSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class)
            ->add('street', TextType::class, ['required' => false])
            ->add('postalCode', TextType::class, ['required' => false]);

        $builder->get('city')->addModelTransformer(new CityNameTransformer());

        $builder->get('postalCode')->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            if ('01-234' === $event->getData()) {
                $event->getForm()->getParent()->add('name', TextType::class, ['required' => false, 'mapped' => false]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
