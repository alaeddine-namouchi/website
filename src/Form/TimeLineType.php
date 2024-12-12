<?php

namespace App\Form;

use App\Entity\TimeLine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimeLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('stepDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('description')
            ->add('article_type', ChoiceType::class, [
                'placeholder' => 'Choisir type',
                'choices'  => [
                    'Article' => 'article',
                    'Titre de bloque ' => 'title_bloc',
                ],
                "required" => true, "attr" => ["class" => "form-control"]
        ])
            ->add('icon', FileType::class, [
                'mapped' => false,
                'required' => false
            ])
            //->add('icon', FileType::class, array('data_class' => null,'required' => false))
            ->add('published', CheckboxType::class, [ 'label' => false, 'attr' => [ "class" => "form-check-input" ,"value" => 0,'style' => "height:20px; width: 40px; ",  "required" => false ], "row_attr" => ['class' => 'form-switch pt-2' , 'style' => "padding-left: 10px!important;"] ])
            //->add('article')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TimeLine::class,
        ]);
    }
}
