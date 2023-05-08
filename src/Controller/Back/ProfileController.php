<?php

namespace App\Controller\Back;

use App\Entity\ProfilAction;
use App\Entity\Profile;
use App\Form\ProfileType;
use App\Repository\ActionRepository;
use App\Repository\ProfileRepository;
use App\Repository\SectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @Route("/back/{_locale}/profile")
 * 
 * Class ProfilController
 * @package App\Controller
 *
 * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
 */
 
class ProfileController extends AbstractController
{
    /**
     * @Route("/", name="app_profile_index", methods={"GET"})
     */
    public function index(ProfileRepository $profilRepository): Response
    {
        $profils = $profilRepository->findAll();
        return $this->render('back/profile/index.html.twig', [
            'profiles' => $profils,
        ]);
    }

    /**
     * @Route("/new", name="app_profile_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $profil = new Profile();
        $form = $this->createForm(ProfileType::class, $profil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($profil);
            $entityManager->flush();

            return $this->redirectToRoute('app_profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/profile/new.html.twig', [
            'profile' => $profil,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_profile_show", methods={"GET"})
     */
    public function show(Profile $profil): Response
    {
        return $this->render('back/profile/show.html.twig', [
            'profile' => $profil,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_profile_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Profile $profil, EntityManagerInterface $entityManager, SectionRepository $sectionRepository, 
    ActionRepository $actionRepository,
    ManagerRegistry $doctrine): Response
    {   
        $form = $this->createForm(ProfileType::class, $profil);
        $form->handleRequest($request);
        dump($form);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_profile_index', [], Response::HTTP_SEE_OTHER);
        }

        $sections = $sectionRepository->findAll();
        $allPrivileges = true;
        $res =  $sectionRepository->findBy(['allAction' => false]);
        dump($profil->getId());
        if(count($res ) > 0) $allPrivileges = false;
        $profilActions = $this->getDoctrine()->getRepository(ProfilAction::class)->findBy(['profile' => $profil->getId()]);
        // $profilActions = $doctrine->getRepository(ProfilAction::class)->findBy(['profile' => $profil->getId()]);
     
        return $this->render('back/profile/edit.html.twig', [
            'profile' => $profil,
            'profile_id' => $profil->getId(),
            'sections'=> $sections,
            'all_privileges' => $allPrivileges,
            'profil_actions'=> $profilActions,            
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_profile_delete", methods={"POST"})
     */
    public function delete(Request $request, Profile $profil, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profil->getId(), $request->request->get('_token'))) {
            $entityManager->remove($profil);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_profile_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
