<?php

namespace App\Form;

use App\Entity\Admin;
use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class AdminUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname')
        ->add('lastname')
        ->add('profile', EntityType::class, [ "attr" => ["class" => "form-control "],
        'placeholder' => 'Choisir Profil',
        'class' => Profile::class,
        'choice_label' => 'label',
    ])
            ->add('email')
            ->add('roles', ChoiceType::class, [ "attr" => ["class" => "form-control d-none "],
//                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                  'User' => 'ROLE_USER',
                  'Administrateur' => 'ROLE_ADMIN',
                  'Super User' => 'ROLE_SUPER_USER',
                ],
                // 'multiple'  => true,
            ])
        ->add('workUnit')
        ->add('phoneNumber')

            ->add('isVerified', ChoiceType::class, [
                'choices'  => [
                    'Vérifié' => true,
                    'Non Vérifié' => false,
                ],
        ])
        ;

        // Data transformer
        $builder->get('roles')
        ->addModelTransformer(new CallbackTransformer(
            function ($rolesArray) {
                 // transform the array to a string
                 return count($rolesArray)? $rolesArray[0]: null;
            },
            function ($rolesString) {
                 // transform the string back to an array
                 return [$rolesString];
            }
    ));

    }




    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Admin::class,
        ]);
    }
}
