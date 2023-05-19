<?php

namespace App\Controller\Front;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 
 * @Route("/{_locale}/contact", requirements={  "_locale": "fr|ar|en"   })
 */

class ContactController extends AbstractController
{

    /**
     * @Route("/new", name="front_contact_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ContactRepository $contactRepository, MenuRepository $menuRepository): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->add($contact);
            
            $this->addFlash('success', 'Votre Message a été envoyé avec succès');
            return $this->redirectToRoute('front_contact_new');
        }

        return $this->renderForm('front/fr/contact.html.twig', [
            'contact' => $contact,
            'form' => $form,
            'menus' => $menuRepository->findAll(),
            'current_page'=> 'Formulaire de Contact',
        ]);
    }

   
}
