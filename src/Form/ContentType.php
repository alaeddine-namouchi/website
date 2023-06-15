<?php

namespace App\Form;

use App\Entity\Content;
use App\Entity\Scope;
use App\Repository\ScopeRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class ContentType extends AbstractType
{
    /**
     * Constructor
     *
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        Security               $security,
        EntityManagerInterface $entityManager
    )
    {

        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('scope', EntityType::class, ["required" => true, "attr" => ["class" => "form-control",],
                'placeholder' => 'Choisir rubrique',
                'class' => Scope::class,
                'query_builder' => function (ScopeRepository $repo) {
                    return $repo->scopeProfileQueryBuilder();
                },
                'choice_label' => 'name',
            ])
            ->add('title', TextType::class, ['required' => true])
            ->add('title', TextType::class, ['required' => true])
            ->add('intro')
//            ->add('scope', HiddenType::class)
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
                "row_attr" => ['class' => 'col-lg-8']])
            ->add('tags', TextType::class,
                ['attr' => ['data-role' => "tagsinput", 'data-tag-class' => "badge badge-primary", 'class' => "form-control"
                ]])
            ->add('published_date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('published', CheckboxType::class, ["required" => false, 'attr' => ["class" => "form-check-input", 'style' => "height:20px; width: 40px; "], "row_attr" => ['class' => 'form-switch pt-2', 'style' => "padding-left: 10px!important;"]])
            ->add('fullWidth', CheckboxType::class, ["required" => false, 'attr' => ["class" => "form-check-input", 'style' => "height:20px; width: 40px; "], "row_attr" => ['class' => 'form-switch pt-2', 'style' => "padding-left: 10px!important;"]])
            ->add('picture', FileType::class, [
                'mapped' => false,
                'required' => false,
               'label' => 'image',
               'attr' =>
        ['data-tag-class' => "badge badge-primary", 'class' => "form-control"],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Content::class,
        ]);
    }
}
