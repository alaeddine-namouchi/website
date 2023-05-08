<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Content;
use App\Entity\Language;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title' , TextType::class, [ 'required' => true ])
            ->add('intro')
            ->add('body', CKEditorType::class, [ 
                'config' => array(
                    'stylesSet' => 'my_styles',
                ), 
                
    'styles' => array(
        'my_styles' => array(
            // array('name' => 'Blue Title', 'element' => 'h2', 'styles' => array('color' => 'Blue')),
            array('name' => 'cssCKE', 'element' => 'span', 'attributes' => array('class' => 'my_cssCKE')),
            // array('name' => 'Multiple Element Style', 'element' => array('h2', 'span'), 'attributes' => array('class' => 'my_class')),
            // array('name' => 'Widget Style', 'type' => 'widget' , 'widget' => 'my_widget', 'attributes' => array('class' => 'my_widget_style')),
        ),
    ),
            "row_attr" => ['class' => 'col-lg-8' ] ])
           // ->add('slug', TextType::class)
            ->add('tags', TextType::class, 
            ['attr' => ['data-role' => "tagsinput", 'data-tag-class'=>"badge badge-primary", 'class' => "form-control"
                    ]])
            ->add('published_date', DateType::class, [
                'widget' => 'single_text',
            ])

            ->add('published', CheckboxType::class, ["required" => false, 'attr' => [ "class" => "form-check-input" ,'style' => "height:20px; width: 40px; " ], "row_attr" => ['class' => 'form-switch pt-2' , 'style' => "padding-left: 10px!important;"] ])
            //->add('author_id')
        //     ->add('language', EntityType::class, [ "attr" => ["class" => "form-control "],
        //                 'placeholder' => 'Choisir Langue',
        //                 'class' => Language::class,
        //                 'choice_label' => 'name',
        // ])
          //  ->add('article', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Content::class,
        ]);
    }
}
