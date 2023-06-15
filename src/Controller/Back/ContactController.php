<?php

namespace App\Controller\Back;

use App\Entity\Contact;
use App\Entity\ContactTheme;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Repository\ContactThemeRepository;
use App\Repository\ThemeRepository;
use App\Service\ContactService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security as Sec;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @Route("/back/{_locale}/contact", requirements={  "_locale": "fr|ar|en"   })
 *
 * @Sec("is_granted('IS_AUTHENTICATED_FULLY')")
 *
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="app_contact_index", methods={"GET"})
     */
    public function index(Request $request, ContactService $contactService): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);
        $contacts = $contactService->getContacts($page, $limit);
        return $this->render('back/contact/index.html.twig', [
            'pagination' => $contacts,
        ]);
    }

    /**
     * @Route("/new", name="app_contact_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->add($contact);
            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_contact_show", methods={"GET"})
     */
    public function show(
        Contact                $contact,
        ContactRepository      $contactRepository,
        ThemeRepository        $themeRepository,
        EntityManagerInterface $entityManager): Response
    {

        $themes = $themeRepository->findBy(['isActive' => true]);

        $contact->setReadAt(new \DateTimeImmutable());
        $contactRepository->add($contact);
        $contactThemes = $entityManager->getRepository(ContactTheme::class)->findBy(['contact' => $contact->getId()]);
        return $this->render('back/contact/show.html.twig', [
            'contact' => $contact,
            'themes' => $themes,
            'contact_themes' => $contactThemes
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_contact_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Contact $contact, ContactRepository $contactRepository): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->add($contact);
            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/theme/add", name="app_contact_add_theme", methods={"POST"})
     */
    public function addTheme(
        Request                $request,
        ContactRepository      $contactRepository,
        ThemeRepository        $themeRepository,
        EntityManagerInterface $entityManager): Response
    {
        $contactId = $request->request->get('contact_id');
        $themeId = $request->request->get('theme_id');
        $contact = $contactRepository->find($contactId);
        $theme = $themeRepository->find($themeId);
        $contactTheme = new ContactTheme();
        $contactTheme->setContact($contact)->setTheme($theme);
        $entityManager->persist($contactTheme);
        $entityManager->flush();

        return $this->json(["save" => true, 'theme_id' => $theme->getId()]);
    }


    /**
     * @Route("/theme/remove", name="app_contact_remove_theme", methods={"POST"})
     */
    public function removeTheme(
        Request                $request,
        ContactRepository      $contactRepository,
        ThemeRepository        $themeRepository,
        ContactThemeRepository $contactThemeRepository,
        EntityManagerInterface $entityManager): Response
    {
        $contactId = $request->request->get('contact_id');
        $themeId = $request->request->get('theme_id');
        $contact = $contactRepository->find($contactId);
        $theme = $themeRepository->find($themeId);
        $contactTheme = $contactThemeRepository->findOneBy(['theme' => $theme, 'contact' => $contact ]);
        $entityManager->remove($contactTheme);
        $entityManager->flush();

        return $this->json(["save" => true,  'theme_id' => $theme->getId()]);
    }

    /**
     * @Route("/{id}", name="app_contact_delete", methods={"POST"})
     */
    public function delete(Request $request, Contact $contact, ContactRepository $contactRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $contact->getId(), $request->request->get('_token'))) {
            $contactRepository->remove($contact);
        }

        return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    }
}
