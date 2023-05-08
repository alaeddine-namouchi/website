<?php

namespace App\Controller\Back;

use App\Entity\Action;
use App\Entity\Profile;
use App\Entity\Section;
use App\Entity\ProfilAction;
use App\Form\ActionType;
use App\Repository\ActionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/{_locale}/action")
 * 
 */
class ActionController extends AbstractController
{
    /**
     * @Route("/", name="action_index", methods={"GET"})
     */
    public function index(ActionRepository $actionRepository): Response
    {
        return $this->render('back/action/index.html.twig', [
            'actions' => $actionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="action_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $action = new Action();
        $form = $this->createForm(ActionType::class, $action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($action);
            $entityManager->flush();

            return $this->redirectToRoute('back/action_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/action/new.html.twig', [
            'action' => $action,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="action_show", methods={"GET"})
     */
    public function show(Action $action): Response
    {
        return $this->render('back/action/show.html.twig', [
            'action' => $action,
        ]);
    }

    /**
     * @Route("/profil/add", name="new_action_profil", methods={"POST"})
     */

    public function addActionProfil(Request $request,  EntityManagerInterface $entityManager, ActionRepository $actionRepository): Response
    {
        $profilId = $request->request->get('profil_id');
        $actionId = $request->request->get('action_id');
        //dump($request);
        $profil = $this->getDoctrine()->getRepository(Profile::class)->find($profilId);
        $action = $actionRepository->find($actionId);
        $profilAction = new ProfilAction();
        $profilAction->setProfile($profil)->setAction($action);
        $entityManager->persist($profilAction);
       // dump($profilAction);
        //die;
        $allAction = false;
        $section = $action->getSection();
        $numbeOfAction = count($section->getActions());
        $numbeOfActionPrfil = $actionRepository->getNumberOfActionProfilBySection($section->getId(), $profilId);
        // dump($numbeOfActionPrfil);
        $numbeOfActionPrfil = (int) $numbeOfActionPrfil[0];
        if($numbeOfAction <= $numbeOfActionPrfil + 1)
        {
            $section->setAllAction(true); 
            $allAction = true;
            $entityManager->persist($section);
        }
        
        $entityManager->flush();

        return $this->json(["save" => true, 'all_action' => $allAction, 'section_id' => $section->getId()]);
      
    }

    /**
     * @Route("/profil/delete", name="remove_action_profil", methods={"POST"})
     */

    public function deleteActionProfil(Request $request,  EntityManagerInterface $entityManager): Response
    {
        $profilId = $request->request->get('profil_id');
        $actionId = $request->request->get('action_id');
        $profilActions = $this->getDoctrine()->getRepository(ProfilAction::class)->findBy(array('profile' => $profilId, 'action' => $actionId));;
        $section = $profilActions[0]->getAction()->getSection();
        $section->setAllAction(false);
        $entityManager->persist($section);
        foreach ($profilActions as $profilAction)
        {
            $entityManager->remove($profilAction);
        }
        $entityManager->flush();
    
        return $this->json(["deleted" => true , "section_id" => $section->getId() ]);
      
    }


    /**
     * @Route("/profil/section/add", name="new_actions_profil_by_section", methods={"POST"})
     */

    public function addActionProfilBySection(Request $request,  EntityManagerInterface $entityManager): Response
    {
        $profilId = $request->request->get('profil_id');
        $sectionId = $request->request->get('section_id');
        //dump($request);
        $profil = $this->getDoctrine()->getRepository(Profile::class)->find($profilId);
        $section = $this->getDoctrine()->getRepository(Section::class)->find($sectionId);
        $actions = $this->getDoctrine()->getRepository(Action::class)->findBy(['section' => $sectionId]);
        $newActions= [];

        foreach($actions as $action)
        {
            $pa = $this->getDoctrine()->getRepository(ProfilAction::class)->findBy(['action' => $action->getId(), 'profile'=> $profilId]);
            if(count($pa) == 0)
            {
              // dump($action->getId());  
                $profilAction = new ProfilAction();
                $profilAction->setProfile($profil)->setAction($action);
                $entityManager->persist($profilAction);
                $newActions[] =  $action->getId();
            }
            

        }
        $section->setAllAction(true);
        $entityManager->persist($section);
       // dump($profilAction);
        //die;
        $entityManager->flush();
        return $this->json(["save" => true, 'id_new_actions' => $newActions]);
      
    }

    /**
     * @Route("/profil/section/remove", name="remove_actions_profil_by_section", methods={"POST"})
     */

    public function removeActionProfilBySection(Request $request,  EntityManagerInterface $entityManager): Response
    {
        $profilId = $request->request->get('profil_id');
        $sectionId = $request->request->get('section_id');
        //dump($request);
        $profil = $this->getDoctrine()->getRepository(Profile::class)->find($profilId);
        $section = $this->getDoctrine()->getRepository(Section::class)->find($sectionId);
        $actions = $this->getDoctrine()->getRepository(Action::class)->findBy(['section' => $sectionId]);
        $newActions= [];

        foreach($actions as $action)
        {
            $removeActions[] =  $action->getId();
            $pas = $this->getDoctrine()->getRepository(ProfilAction::class)->findBy(['action' => $action->getId(), 'profile'=> $profilId]);

                foreach ($pas as $profilAction)
                {
                      $entityManager->remove($profilAction);
                }
        }
        $section->setAllAction(false);
        $entityManager->persist($section);
       // dump($profilAction);
        //die;
        $entityManager->flush();
        return $this->json(["deleted" => true, 'id_remove_actions' => $removeActions]);
      
    }
        /**
     * @Route("/profil/action/add/all", name="all_privileges_profil", methods={"POST"})
     */

    public function allPrivilegesProfil(Request $request,  EntityManagerInterface $entityManager): Response
    {
        $profilId = $request->request->get('profil_id');
       
        $sections = $this->getDoctrine()->getRepository(Section::class)->findAll();
        $profil = $this->getDoctrine()->getRepository(Profile::class)->find($profilId);
        $idActions = [];
        foreach($sections as $section)
        {
            foreach($section->getActions() as $action)
            {
                $pa = $this->getDoctrine()->getRepository(ProfilAction::class)->findBy(['action' => $action->getId(), 'profile'=> $profilId]);
                if(count($pa) == 0)
                {

                    $profilAction = new ProfilAction();
                    $profilAction->setProfile($profil)->setAction($action);
                    $entityManager->persist($profilAction);
                    $idActions[] =  $action->getId();
                }
                

            }
            $section->setAllAction(true);
            $entityManager->persist($section);
        }
        $entityManager->flush();
        return $this->json(["save" => true, 'id_actions' => $idActions]);
      
    }


     /**
     * @Route("/profil/action/remove/all", name="remove_all_privileges_profil", methods={"POST"})
     */

    public function removeAllPrivilegesProfil(Request $request,  EntityManagerInterface $entityManager): Response
    {
        $profilId = $request->request->get('profil_id');
        $sections = $this->getDoctrine()->getRepository(Section::class)->findAll();
        $profil = $this->getDoctrine()->getRepository(Profile::class)->find($profilId);
        $idActions = [];
        foreach($sections as $section)
        {
            foreach($section->getActions() as $action)
            {
                $pa = $this->getDoctrine()->getRepository(ProfilAction::class)->findBy(['action' => $action->getId(), 'profile'=> $profilId]);
                if(count($pa) > 0)
                {
                    $profilAction = new ProfilAction();
                    $profilAction->setProfile($profil)->setAction($action);
                    $entityManager->remove($profilAction);
                    $idActions[] =  $action->getId();
                }
            }
            $section->setAllAction(false);
            $entityManager->persist($section);
        }
        $entityManager->flush();
        return $this->json(["save" => true, 'id_actions' => $idActions]);
    }

    /**
     * @Route("/{id}/edit", name="action_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Action $action, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActionType::class, $action);
        $form->handleRequest($request);
        // dump($form);
        // die;
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('action_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/action/edit.html.twig', [
            'action' => $action,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="action_delete", methods={"POST"})
     */
    public function delete(Request $request, Action $action, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$action->getId(), $request->request->get('_token'))) {
            $entityManager->remove($action);
            $entityManager->flush();
        }

        return $this->redirectToRoute('action_index', [], Response::HTTP_SEE_OTHER);
    }
}
