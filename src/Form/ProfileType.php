<?php

namespace App\Form;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('label', TextType::class,array(
            "attr" => array(
                "class" => "form-control "
                )
        ))
        ->add('alias', TextType::class,array(
            "attr" => array(
                "class" => "form-control "
                )
        ))

        ->add('description', TextType::class,array(
            "attr" => array(
                "class" => "form-control "
                )
        ))
        ;
    }

  

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
