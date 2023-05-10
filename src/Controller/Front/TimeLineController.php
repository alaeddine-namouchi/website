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
     * @Route("/", name="front_history_index", methods={"GET"})
     */
    public function show(TimeLineService $timeLineService, LanguageService $languageService, Request $request): Response
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


 
    
}
