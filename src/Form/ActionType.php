<?php

namespace App\Form;

use App\Entity\Action;
use App\Entity\Section;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('label', TextType::class,array(
            "attr" => array(
                "class" => "form-control ")
        ))
        ->add('alias', TextType::class, ["attr" => ["class" => "form-control "]])
        ->add('route', TextType::class, ["attr" => ["class" => "form-control "]])
        ->add('section',EntityType::class, [ "attr" => ["class" => "form-control "],
            'placeholder' => 'Choisir Rubrique',
            'class' => Section::class,
            'choice_label' => 'label',
        ])
        ->add('actionType',EntityType::class, [ "attr" => ["class" => "form-control action_type_linked"],
        
            'placeholder' => 'Choisir type d\'Action',
            'class' => 'App\Entity\ActionType',
            'choice_label' => 'label',
        ])
        ->add('action',EntityType::class, [ "attr" => ["class" => "form-control action_action_linked"] , "required"=>false,
            'placeholder' => 'Choisir Action liée',
            'label' => 'Choisir Action liée',
            'class' => Action::class,
            'choice_label' => 'route',
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Action::class,
        ]);
    }
}
