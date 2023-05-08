<?php

namespace App\Controller\Back;

use App\Entity\TimeLine;
use App\Form\TimeLineType;
use App\Repository\LanguageRepository;
use App\Repository\TimeLineRepository;
use App\Service\FileUploaderService;
use App\Service\LanguageService;
use App\Service\TimeLineService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * 
 * @Route("/back/{_locale}/time/line", requirements={  "_locale": "fr|ar|en"   })
 * 
 */
class TimeLineController extends AbstractController
{
    /**
     * @Route("/", name="app_time_line_index", methods={"GET"})
     */
    public function index(TimeLineService $timeLineService, LanguageService $languageService, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 5);
        // $name = $paramFetcher->get('name');
		// $depot_id = $paramFetcher->get('depot_id');
		// $line_type_id = $paramFetcher->get('line_type_id');
		// $network_id = $paramFetcher->get('network_id');

        
        $lang_from_url = $languageService->getUsedLanguage($request);
        // $listConent  = $timeLineRepository->findBy(['language' => $lang_from_url], ['createdAt' => 'DESC']);
        $listConent  = $timeLineService->getTimeLines($page, $limit, $lang_from_url->getId());
        return $this->render('back/time_line/index.html.twig', [
            'pagination' => $listConent,
        ]);
    }


     /**
     * @Route("/new", name="app_time_line_new", methods={"GET", "POST"})
     */
    public function new(FileUploaderService $fileUploaderService, Request $request, SluggerInterface $slugger, TimeLineRepository $timeLineRepository, LanguageService $languageService): Response
    {
        $timeLine = new TimeLine();
        $type = $request->query->get('type');
        dump($type);
        $form = $this->createForm(TimeLineType::class, $timeLine);
        $form->handleRequest($request);
        $objlangUsed= $languageService->getUsedLanguage($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $timeLine->setArticle($type);
            $timeLine->setLanguage($objlangUsed);
            /** @var UploadedFile $brochureFile */
            $iconFile = $form->get('icon')->getData();
            if ($iconFile) {
                $newFilename = $fileUploaderService->upload($iconFile);
                $timeLine->setIcon($newFilename);
                $timeLineRepository->add($timeLine);
                return $this->redirectToRoute('app_time_line_index', [], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->renderForm('back/time_line/new.html.twig', [
            'time_line' => $timeLine,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/news", name="app_time_line_all_news", methods={"GET"})
     */
    public function news( Request $request, TimeLineService $timeLineService,  TimeLineRepository $timeLineRepository, LanguageService $languageService): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 5);
        
        $lang_from_url = $languageService->getUsedLanguage($request);
        // $listConent  = $timeLineRepository->findBy(['language' => $lang_from_url], ['createdAt' => 'DESC']);
        $listNews  = $timeLineService->getTimeLineByCategory($page, $limit, $lang_from_url->getId());
        return $this->render('back/time_line/index.html.twig', [
            'title' => 'All News',
            'pagination' => $listNews,
        ]);
    }

    /**
     * @Route("/{id}", name="app_time_line_show", methods={"GET"})
     */
    public function show(TimeLine $timeLine): Response
    {
        return $this->render('back/time_line/show.html.twig', [
            'time_line' => $timeLine,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_time_line_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, SluggerInterface $slugger, TimeLine $timeLine, TimeLineRepository $timeLineRepository, LanguageRepository $languageRepository): Response
    {
        $form = $this->createForm(TimeLineType::class, $timeLine);
        $form->handleRequest($request);
        $loc_url = $request->getSession()->get('_locale');
        $lang_from_url = $languageRepository->findOneByAlias($loc_url);
        $listContentTimeLine  = $timeLineRepository->findBy(['language' => $lang_from_url], ['createdAt' => 'DESC']);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['icon']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $timeLine->setIcon($newFilename);
            }
            
            $timeLineRepository->add($timeLine);
           // return $this->redirectToRoute('app_time_line_index', [], Response::HTTP_SEE_OTHER);
        }
        $urlicon = $destination = $this->getParameter('kernel.project_dir').'/public/uploads/'.$timeLine->getIcon();
        return $this->renderForm('back/time_line/edit.html.twig', [
            'time_line' => $timeLine,
            'urlicon' => $urlicon,
            'form' => $form,
            'time_lines' => $listContentTimeLine
        ]);
    }

    /**
     * @Route("/{id}", name="app_time_line_delete", methods={"POST"})
     */
    public function delete(Request $request, TimeLine $timeLine, TimeLineRepository $timeLineRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$timeLine->getId(), $request->request->get('_token'))) {
            $timeLineRepository->remove($timeLine);
        }

        return $this->redirectToRoute('app_time_line_index', [], Response::HTTP_SEE_OTHER);
    }
}
