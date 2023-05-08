<?php

namespace App\Controller\Front;

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
 * @Route("/{_locale}/history-transport", requirements={  "_locale": "fr|ar|en"   })
 * 
 */
class TimeLineController extends AbstractController
{
    /**
     * @Route("/", name="app_history_index", methods={"GET"})
     */
    public function index(TimeLineService $timeLineService, LanguageService $languageService, Request $request): Response
    {
        
        // dd($request);

        
        $lang_from_url = $languageService->getUsedLanguage($request);

        // $listConent  = $timeLineRepository->findBy(['language' => $lang_from_url], ['createdAt' => 'DESC']);
        $listConent  = $timeLineService->getHistory( $lang_from_url->getId());
        return $this->render('front/fr/time_line/time-line.html.twig', [
            'pagination' => $listConent,
            'title' => "Historique Transport"
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
     * @Route("/news", name="app_time_line_new", methods={"GET", "POST"})
     */
    public function news(FileUploaderService $fileUploaderService, Request $request, SluggerInterface $slugger, TimeLineRepository $timeLineRepository, LanguageService $languageService): Response
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
