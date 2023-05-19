<?php

namespace App\Controller\Front;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Contact;
use App\Entity\Content;
use App\Entity\Language;
use App\Form\ContentType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\ContentRepository;
use App\Repository\LanguageRepository;
use App\Repository\MenuRepository;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security as Sec;

/**
 * @Route("/{_locale}", requirements={  "_locale": "fr|ar|en"   })
 * 
 * 
 */
class ContentController extends AbstractController
{
    private $security;
    private $articleRepository;
    private $contentRepository;
    private $languageRepository;
    private $categoryRepository;
    private $menuRepository;
    private $translator;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     *  constructor.
     */
    public function __construct(LoggerInterface $logger,
                                Security $security, 
                                MenuRepository $menuRepository,
                                ContentRepository $contentRepository, 
                                LanguageRepository $languageRepository, 
                                CategoryRepository $categoryRepository, 
                                ArticleRepository $articleRepository,
                                TranslatorInterface $translator)
                            {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
        $this->articleRepository = $articleRepository;
        $this->contentRepository = $contentRepository;
        $this->languageRepository = $languageRepository;
        $this->categoryRepository = $categoryRepository;
        $this->translator = $translator;
        $this->menuRepository = $menuRepository;
        $this->logger = $logger;

    }


    
  
    public function translateContentArticle(Request $request,  $id, LanguageRepository $languageRepository, ContentRepository $contentRepository, CategoryRepository $categoryRepository, ArticleRepository $articleRepository): Response
    {   
        $content = new Content();
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);
        $loc_url = $request->getSession()->get('_locale');
        $objlang_from_url = $languageRepository->findOneByAlias($loc_url);
        $content->setLanguage($objlang_from_url);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $article = $contentRepository->find($id)->getArticle();
            $articleRepository->add($article);
            $content->setArticle($article);
            dump($content);
            $contentRepository->add($content);
            return $this->redirectToRoute('app_content_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/content/new.html.twig', [
            'content' => $content,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{slug}/{id}", name="front_content_show", methods={"GET"} )
     */
    public function show($slug, $id, Request $request): Response
    {

        
        $content = $this->contentRepository->find($id);
        // $loc_url = $request->getSession()->get('_locale');
        // $article = $content->getArticle();

        if ($content->getSlug() !== $slug) {
            return $this->redirectToRoute('front_content_show', ['id' => $content->getId(), 'slug' => $content->getSlug()],
                301);
        }
        $loc_url = $request->getSession()->get('_locale') ?? 'fr';
        $objlang_from_url = $this->languageRepository->findOneByAlias($loc_url);
        //dd($objlang_from_url);
        $article  = $content->getArticle();
        $content = $this->validContentFront( $objlang_from_url,  $article);
        $loc_url = $request->getSession()->get('_locale');
        $currentLang = $objlang_from_url->getName();
    
        if($article->getCategory()->getAlias() == 'SIMPLE'){
            return $this->render('front/fr/access-to-information.html.twig', [
                'content_page' => $content->getBody(), 
                'slug'=> $slug,
                'current_page'=> $content->getTitle(),
                'menus' => $this->menuRepository->findAll(),
            
            ]);
        }
        if($article->getCategory()->getAlias() == 'FORM'){
            return $this->redirectToRoute('front_content_new', [], Response::HTTP_SEE_OTHER);

        }

        // if($article->getCategory()->getAlias() == 'FORM'){

        //     $contact = new Contact();
        // $form = $this->createForm(ContactType::class, $contact);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $contactRepository->add($contact);
        //     return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        // }

        // return $this->renderForm('back/contact/new.html.twig', [
        //     'contact' => $contact,
        //     'form' => $form,
        // ]);
        //     return $this->render('front/fr/contact.html.twig', [
        //         'current_page'=> $content->getTitle(),
        //         'form_name' => 'form-contact',
        //         'menus' => $this->menuRepository->findAll(),
                
            
        //     ]);
        // }

        
    }



  


    public function firstNWord(String $sentence, int $rankWord)
    {
        $str = trim(strip_tags($sentence));

    return implode(' ', array_slice(explode(' ', $str), 0, $rankWord)) .  " ...";

    }
    
    public function typeOfAction(Language $lang, Article $article){

        $content = $this->contentRepository->findBy(['language' => $lang, 'article' => $article]);

        if(count($content) > 0){
            return 'edit';

        }else{
            return 'new';
        }


    }
    public function validContentFront(Language $lang, Article $article){
        $exist = $this->contentRepository->findBy([ 'article' => $article]);
        if(count($exist) < 1){
            return $this->redirectToRoute('front_content_index', [], Response::HTTP_SEE_OTHER);
        }
        $content = $this->contentRepository->findBy(['language' => $lang, 'article' => $article]);
        if(count($content) === 0){
            return false;
        }
        if(count($content) == 1){
            return $content[0];

        }else{
            throw new Exception('content duplicated '. count($content));
        }


    }
}
