<?php

namespace App\Form;

use App\Entity\Content;
use App\Entity\Language;
use App\Entity\Menu;
use App\Repository\ContentRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    private $contentRepository;
    public function __construct(ContentRepository $contentRepository)
    {
        $this->contentRepository = $contentRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $articles = array();
        // $this->contentRepository = $this->em->getRepository(Content::class);
            $articles = $this->contentRepository->findArticleByLang();

        $builder
            ->add('label', null, ["required"=> false,  "attr" => ["class" => "form-control"]])
            ->add('link', null, ["required"=> false,  "attr" => ["class" => "form-control"]])
            ->add('emplacement', ChoiceType::class, [
                'placeholder' => 'Choisir Emplacement',
                'choices'  => [
                    'Prémière Niveau' => 'level_one',
                    'Deuxième Niveau' =>  'level_two',
                    'Troixième Niveau' => 'level_three',
                ],
            "required"=> false,  "attr" => ["class" => "form-control"]])
            ->add('typeMenu', ChoiceType::class, [
                'placeholder' => 'Choisir type menu',
                'choices'  => [
                    'Main' => 'main',
                    'Plus' =>  'plus',
                    'Footer' => 'footer',
                ],
                "required"=> false,  "attr" => ["class" => "form-control"]])
            ->add('content', EntityType::class, [  "required"=> false, "attr" => ["class" => "form-control",],
            'placeholder' => 'Choisir Article',
            'class' => Content::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                            // ->where('u.language=:lang')
                            // ->setParameter('lang', 'fr')
                            ->orderBy('u.created_at', 'DESC');
            },
            'choice_label' => 'title',
        ])

        // ->add('content', EntityType::class, [ "attr" => ["class" => "form-control "],
        //     'placeholder' => 'Choisir Article',
        //     'class' => Content::class,
        //     'choices' => $articles,
        //     'choice_label' => 'title'
        // ])
        ->add('language', EntityType::class, [ "attr" => ["class" => "form-control "],
            'placeholder' => 'Choisir Langue',
            'class' => Language::class,
            'choice_label' => 'name',
        ])
        ->add('parent', EntityType::class, [ "attr" => ["class" => "form-control "], "required"=> false,
        'placeholder' => 'Choisir Langue',
        'class' => Menu::class,
        'choice_label' => 'label',
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
