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
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

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
    private $contentService;
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
    public function __construct(LoggerInterface     $logger,
                                Security            $security,
                                MenuRepository      $menuRepository,
                                ContentRepository   $contentRepository,
                                ContentService      $contentService,
                                LanguageRepository  $languageRepository,
                                CategoryRepository  $categoryRepository,
                                ArticleRepository   $articleRepository,
                                TranslatorInterface $translator
    )
    {
        $this->security = $security;
        $this->articleRepository = $articleRepository;
        $this->contentRepository = $contentRepository;
        $this->contentService = $contentService;
        $this->languageRepository = $languageRepository;
        $this->categoryRepository = $categoryRepository;
        $this->translator = $translator;
        $this->menuRepository = $menuRepository;
        $this->logger = $logger;

    }


    /**
     * @Route("/", name="front_content_index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $locLang = $request->getLocale();
        if (! in_array($locLang, ['fr', 'ar'])) {
            return $this->redirectToRoute('front_content_index', [], Response::HTTP_SEE_OTHER);
        }
        $category = $this->categoryRepository->findOneByAlias('NEWS');
        $articles = $this->articleRepository->findBy(['category' => $category]);
        $language = $this->languageRepository->findOneBy(['alias' => $locLang]);
        $articleIds = [];
        foreach ($articles as $article) {
            $articleIds[] = $article->getId();
        }
        $contents = $this->contentService->getContentByArticles(1, 3, $language->getId(), $articleIds);
        return $this->render('front/' . $locLang . '/index.html.twig', [
            'contents' => $contents,
        ]);
    }

    /**
     * @Route("/", name="front_menu_main", methods={"GET"})
     */
    public function mainMenu($_locale): Response
    {
        $category = $this->categoryRepository->findOneBy(['alias' => 'fr']);
        $language = $this->languageRepository->findOneBy(['alias' => $_locale]);
        $plusMenu = $this->menuRepository->findBy([
            'language' => $language,
            'typeMenu' => 'plus',
            'emplacement' => 'level_two'
        ], ['parent' => 'ASC']);
        $mainMenu = $this->menuRepository->findBy([
            'language' => $language,
            'typeMenu' => 'main',
            'emplacement' => 'level_one'
        ], ['parent' => 'ASC']);
        return $this->render('front/' . $_locale . '/bloc/header.html.twig', [
            'menus' => $plusMenu,
            'main_menu' => $mainMenu
        ]);
    }

    /**
     * @Route("/{slug}/{id}", name="front_content_show", methods={"GET"} )
     */
    public function show($slug, $id, Request $request): Response
    {
        $loc_url = $request->getLocale() ?? 'fr';
        $lang_from_url = $this->languageRepository->findOneByAlias($loc_url);
        $article = $this->articleRepository->findOneBy(['num'=> $id]);
        $content = $this->contentRepository->findOneBy(['article'=> $article, 'language' => $lang_from_url ] );
        if(!$content){
            // a implementer un page d'information(....Cet contenu est tranduit en arabe) avant la  redirection à la page d'accueil
            return $this->redirectToRoute('front_content_index', [], Response::HTTP_SEE_OTHER);
        }
        if ($content->getSlug() !== $slug) {
            return $this->redirectToRoute('front_content_show', ['id' => $article->getNum(), 'slug' => $content->getSlug()],
                301);
        }

        $article = $content->getArticle();
        $content = $this->validContentFront($lang_from_url, $article);
        $loc_url = $request->get('_locale');
        if (in_array($article->getCategory()->getAlias(), ['SIMPLE', 'AREA_JOURNALIST', 'NEWS', 'FORM'])) {
            return $this->render('front/' . $loc_url. '/simple.html.twig', [
                'content' => $content,
                'slug' => $slug,
                'current_page' => $content->getTitle(),
                'local_lang' => $loc_url
            ]);
//        }
       /* if ($article->getCategory()->getAlias() == 'NEWS') {
            return $this->render('front/' . $loc_url. '/news.html.twig', [
                'content' => $content,
                'slug' => $slug,
                'current_page' => $content->getTitle(),
            ]);
        }*/
//        if ($article->getCategory()->getAlias() == 'NEWS') {
//            return $this->redirectToRoute('front_content_news', [], Response::HTTP_SEE_OTHER);
//        }
//        if ($article->getCategory()->getAlias() == 'AREA_JOURNALIST') {
//            return $this->redirectToRoute('front_content_area', [], Response::HTTP_SEE_OTHER);
//        }
//        if ($article->getCategory()->getAlias() == 'WELCOME') {
//            return $this->redirectToRoute('front_content_index', [], Response::HTTP_SEE_OTHER);
//        }
//        if ($article->getCategory()->getAlias() == 'FORM') {
//            return $this->redirectToRoute('front_contact_new', [], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('front_content_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/news", name="front_content_news", methods={"GET"} )
     */
    public function showNews(Request $request, ContentService $contentService, LanguageService $languageService): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 2);
        $category = $this->categoryRepository->findOneByAlias('NEWS');
        $aliasLocaleLang = $request->getLocale() ?? 'fr';
        $lang_from_url = $this->languageRepository->findOneByAlias($aliasLocaleLang);
        $articles = $this->articleRepository->findBy(['category' => $category]);
        $articleIds = [];
        foreach ($articles as $article) {
            $articleIds[] = $article->getId();
        }
        $contents = $contentService->getContentByArticles($page, $limit, $lang_from_url->getId(), $articleIds);
        $current_page = [
            'ar' => 'الأخبار',
            'fr'=>'Les Dernières Nouvelles'


        ];
        if ($article->getCategory()->getAlias() == 'NEWS') {

            return $this->render('front/' . $aliasLocaleLang . '/all-news.html.twig', [
                'contents' => $contents,
                'current_page' => $current_page[$aliasLocaleLang],
            ]);


        } else {
            return $this->redirectToRoute('front_content_index', [], Response::HTTP_SEE_OTHER);
        }

    }


    /**
     * @Route("/area-journatist", name="front_content_area", methods={"GET"} )
     */
    public function showArea(Request $request, ContentService $contentService, LanguageService $languageService): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 3);

        $category = $this->categoryRepository->findOneByAlias('AREA_JOURNALIST');
        $loc_url = $request->get('_locale') ?? 'fr';
        $lang_from_url = $this->languageRepository->findOneByAlias($loc_url);
        $articles = $this->articleRepository->findBy(['category' => $category]);
        $articleIds = [];
        foreach ($articles as $article) {
            $articleIds[] = $article->getId();
        }
        $contents = $contentService->getContentByArticles($page, $limit, $lang_from_url->getId(), $articleIds);
        if ($category->getAlias() == 'AREA_JOURNALIST') {
            return $this->render('front/' . $loc_url . '/all-area-journalist.html.twig', [
                'contents' => $contents,
                'current_page' => $category->getLabel(),
            ]);
        } else {
            return $this->redirectToRoute('front_content_index', [], Response::HTTP_SEE_OTHER);
        }

    }

    public function blocNews($_locale): Response
    {
        $category = $this->categoryRepository->findOneByAlias('NEWS');
        $articles = $this->articleRepository->findBy(['category' => $category]);
        $language = $this->languageRepository->findOneBy(['alias' => $_locale]);
        $articleIds = [];
        foreach ($articles as $article) {
            $articleIds[] = $article->getId();
        }
        $contents = $this->contentService->getContentByArticles(1, 3, $language->getId(), $articleIds);
        return $this->render('front/' . $_locale . '/bloc/bloc-news.html.twig', [
            'contents' => $contents,
            'current_page' => $category->getLabel(),
        ]);
    }

    public function footer($_locale): Response
    {
        !in_array($_locale, ['fr', 'ar']) ? $_locale = 'fr' : null;

        $language = $this->languageRepository->findOneBy(['alias' => $_locale]);
        $plusMenu = $this->menuRepository->findBy([
            'language' => $language,
            'typeMenu' => 'plus',
            'emplacement' => 'level_two'
        ], ['parent' => 'ASC']
        );

        return $this->render('front/' . $_locale . '/bloc/footer.html.twig', [
            'menus' => $plusMenu,
        ]);
    }


    public function firstNWord(string $sentence, int $rankWord)
    {
        $str = trim(strip_tags($sentence));
        return implode(' ', array_slice(explode(' ', $str), 0, $rankWord)) . " ...";
    }

    public function typeOfAction(Language $lang, Article $article)
    {
        $content = $this->contentRepository->findBy(['language' => $lang, 'article' => $article]);
        if (count($content) > 0) {
            return 'edit';

        } else {
            return 'new';
        }
    }

    public function validContentFront(Language $lang, Article $article)
    {
        $exist = $this->contentRepository->findBy(['article' => $article]);
        if (count($exist) < 1) {
            return $this->redirectToRoute('front_content_index', [], Response::HTTP_SEE_OTHER);
        }
        $content = $this->contentRepository->findBy(['language' => $lang, 'article' => $article]);
        if (count($content) === 0) {
            return false;
        }
        if (count($content) == 1) {
            return $content[0];
        } else {
            throw new Exception('content duplicated ' . count($content));
        }
    }

    public function translateContentArticle(Request $request, $id, LanguageRepository $languageRepository, ContentRepository $contentRepository, CategoryRepository $categoryRepository, ArticleRepository $articleRepository): Response
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
