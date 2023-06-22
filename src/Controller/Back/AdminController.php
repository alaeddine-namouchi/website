<?php

namespace App\Controller\Back;

use App\Entity\Admin;
use App\Form\AdminType;
use App\Form\AdminUpdateType;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/back/{_locale}/admin")
 *
 */
//@Security("is_granted('IS_AUTHENTICATED_FULLY')")
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_index", methods={"GET"})
     */
    public function index(AdminRepository $adminRepository): Response
    {
        return $this->render('back/admin/index.html.twig', [
            'admins' => $adminRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_new", methods={"GET", "POST"})
     */
    public function new(Request $request,  UserPasswordEncoderInterface $passwordEncoder,  EntityManagerInterface $entityManager
): Response
    {
        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //encodage du mot de passe
            $admin->setPassword(
                $passwordEncoder->encodePassword($admin, $admin->getPassword()));
            $entityManager->persist($admin);
            $entityManager->flush();

//            $adminRepository->add($admin);
            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/admin/new.html.twig', [
            'admin' => $admin,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_show", methods={"GET"})
     */
    public function show(Admin $admin): Response
    {
        return $this->render('back/admin/show.html.twig', [
            'admin' => $admin,
        ]);
    }

    /**
     * @Route("/public/{id}", name="app_admin_public_show", methods={"GET"})
     */
    public function show_public(Admin $admin): Response
    {
        return $this->render('back/admin/show_public.html.twig', [
            'admin' => $admin,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Admin $admin, AdminRepository $adminRepository): Response
    {
        $form = $this->createForm(AdminUpdateType::class, $admin);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adminRepository->add($admin);
            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/admin/edit.html.twig', [
            'admin' => $admin,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_delete", methods={"POST"})
     */
    public function delete(Request $request, Admin $admin, AdminRepository $adminRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$admin->getId(), $request->request->get('_token'))) {
            $adminRepository->remove($admin);
        }

        return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
