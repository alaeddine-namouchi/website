<?php

namespace App\Controller\Front;

use App\Entity\Article;
use App\Entity\Content;
use App\Entity\Language;
use App\Form\ContentType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\ContentRepository;
use App\Repository\LanguageRepository;
use App\Repository\MenuRepository;
use App\Service\ContentService;
use App\Service\LanguageService;
use App\Service\TimeLineService;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
        $this->security = $security;
        $this->articleRepository = $articleRepository;
        $this->contentRepository = $contentRepository;
        $this->languageRepository = $languageRepository;
        $this->categoryRepository = $categoryRepository;
        $this->translator = $translator;
        $this->menuRepository = $menuRepository;
        $this->logger = $logger;

    }





    /**
     * @Route("/", name="font_content_index", methods={"GET"})
     */
    public function index( Request $request): Response
    {
        $loc_url1 = $request->get('_locale');
        $loc_url2 = $request->get('_locale');
        dump($loc_url1, $loc_url2);
        $category = $this->categoryRepository->findOneBy(['alias'=> 'fr']);
        $category = $this->languageRepository->findOneBy(['alias'=> 'HOME']);
        $loc_url = $request->get('_locale') ?? 'fr';
        $plusMenu = $this->menuRepository->findBy(['typeMenu' => 'plus', 'emplacement'=>'level_two'], ['parent'=>'ASC']);
            return $this->render('front/fr/index.html.twig', [
                'menus' => $plusMenu,
            ]);
    }
    /**
     * @Route("/{slug}/{id}", name="front_content_show", methods={"GET"} )
     */
    public function show($slug, $id, Request $request): Response
    {
        $content = $this->contentRepository->find($id);
        if ($content->getSlug() !== $slug) {
            return $this->redirectToRoute('front_content_show', ['id' => $content->getId(), 'slug' => $content->getSlug()],
                301);
        }
        $loc_url = $request->get('_locale') ?? 'fr';
        $lang_from_url = $this->languageRepository->findOneByAlias($loc_url);
        //dd($objlang_from_url);
        $article  = $content->getArticle();
        $content = $this->validContentFront( $lang_from_url,  $article);
        $loc_url = $request->get('_locale');
        $currentLang = $lang_from_url->getName();

        $plusMenu = $this->menuRepository->findBy(['typeMenu' => 'plus', 'emplacement'=>'level_two'], ['parent'=>'ASC']);
        if($article->getCategory()->getAlias() == 'SIMPLE'){

            return $this->render('front/fr/access-to-information.html.twig', [
                'content_page' => $content->getBody(),
                'slug'=> $slug,
                'current_page'=> $content->getTitle(),
                'menus' => $plusMenu,

            ]);
        }
        if($article->getCategory()->getAlias() == 'NEWS'){

            return $this->render('front/fr/show-news.html.twig', [
                'content_page' => $content,
                'slug'=> $slug,
                'current_page'=> $content->getTitle(),
                'menus' => $plusMenu,

            ]);
        }
        if($article->getCategory()->getAlias() == 'WELCOME'){
            return $this->redirectToRoute('font_content_index', [], Response::HTTP_SEE_OTHER);

        }
        if($article->getCategory()->getAlias() == 'FORM'){
            return $this->redirectToRoute('font_content_index', [], Response::HTTP_SEE_OTHER);

        }else{
            return $this->redirectToRoute('font_content_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/news", name="front_content_news", methods={"GET"} )
     */
    public function showNews( Request $request, ContentService $contentService, LanguageService $languageService): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 2);

        $category = $this->categoryRepository->findOneByAlias('NEWS');
        $loc_url = $request->get('_locale') ?? 'fr';
        $lang_from_url = $this->languageRepository->findOneByAlias($loc_url);
        $articles = $this->articleRepository->findBy(['category'=> $category]);
        $articleIds = [];
        foreach ($articles as $article){
            $articleIds[] = $article->getId();
        }
        $contents = $contentService->getContentByArticles( $page,  $limit,  $lang_from_url->getId(),  $articleIds);
        $plusMenu = $this->menuRepository->findBy(['typeMenu' => 'plus', 'emplacement'=>'level_two'], ['parent'=>'ASC']);
        if($article->getCategory()->getAlias() == 'NEWS'){

            return $this->render('front/fr/all-news.html.twig', [
                'contents' => $contents,
                'current_page'=> $category->getLabel(),
                'menus' => $plusMenu,

            ]);
        }
        if($article->getCategory()->getAlias() == 'WELCOME'){
            return $this->redirectToRoute('font_content_index', [], Response::HTTP_SEE_OTHER);

        }
        if($article->getCategory()->getAlias() == 'FORM'){
            return $this->redirectToRoute('font_content_index', [], Response::HTTP_SEE_OTHER);

        }else{
            return $this->redirectToRoute('font_content_index', [], Response::HTTP_SEE_OTHER);
        }

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

    public function translateContentArticle(Request $request,  $id, LanguageRepository $languageRepository, ContentRepository $contentRepository, CategoryRepository $categoryRepository, ArticleRepository $articleRepository): Response
    {
        $content = new Content();
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);
        $loc_url = $request->get('_locale');
        $objlang_from_url = $languageRepository->findOneByAlias($loc_url);
        $content->setLanguage($objlang_from_url);

        if ($form->isSubmitted() && $form->isValid()) {

            $article = $contentRepository->find($id)->getArticle();
            $articleRepository->add($article);
            $content->setArticle($article);
//            dump($content);
            $contentRepository->add($content);
            return $this->redirectToRoute('app_content_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/content/new.html.twig', [
            'content' => $content,
            'form' => $form,
        ]);
    }

}
