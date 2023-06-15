<?php

namespace App\Controller\Back;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\LanguageRepository;
use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/{_locale}/menu", requirements={  "_locale": "fr|ar|en"   })
 */
class MenuController extends AbstractController
{
    /**
     * @Route("/", name="app_menu_index", methods={"GET"})
     *
     */
    public function index(Request $request, MenuRepository $menuRepository, LanguageRepository  $languageRepository): Response
    {
        $ms = $menuRepository->findAll();
        $aliasLang = $request->getLocale();
        $language = $languageRepository->findOneBy(['alias' => $aliasLang]);
        return $this->render('back/menu/index.html.twig', [
            'menus' => $menuRepository->findBy(['language' => $language], ['parent'=>'ASC']),
        ]);
    }

    /**
     * @Route("/new", name="app_menu_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MenuRepository $menuRepository): Response
    {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $menuRepository->add($menu);
            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/menu/new.html.twig', [
            'menu' => $menu,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_menu_show", methods={"GET"})
     */
    public function show(Menu $menu): Response
    {
        return $this->render('back/menu/show.html.twig', [
            'menu' => $menu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_menu_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Menu $menu, MenuRepository $menuRepository): Response
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);
//        dd($menu);
        if ($form->isSubmitted() && $form->isValid()) {
            $menuRepository->add($menu);
            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/menu/edit.html.twig', [
            'menu' => $menu,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_menu_delete", methods={"POST"})
     */
    public function delete(Request $request, Menu $menu, MenuRepository $menuRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$menu->getId(), $request->request->get('_token'))) {
            $menuRepository->remove($menu);
        }

        return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
    }
}
