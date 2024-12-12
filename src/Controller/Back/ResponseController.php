<?php

namespace App\Controller\Back;

use App\Entity\Response as ResponseContact;
use App\Form\ResponseType;
use App\Repository\ResponseRepository;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security as Sec;
use Symfony\Component\Security\Core\Security;
use Psr\Log\LoggerInterface;

/**
 * @Route("/back/{_locale}/response")
 * 
 * @Sec("is_granted('IS_AUTHENTICATED_FULLY')")
 */
class ResponseController extends AbstractController
{

    private $security;
    private $contactRepository;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     *  constructor.
     */
    public function __construct(LoggerInterface     $logger,
                                Security            $security,
                                ContactRepository   $contactRepository
                                )
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
        $this->contactRepository = $contactRepository;
        $this->logger = $logger;

    }

    /**
     * @Route("/", name="app_response_index", methods={"GET"})
     * 
     */
    public function index(ResponseRepository $responseRepository): Response
    {
        return $this->render('back/response/index.html.twig', [
            'responses' => $responseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{contact_id}", name="app_response_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ResponseRepository $responseRepository, ContactRepository $contactRepository): Response
    {
        $contactId = $request->get('contact_id');
        $contact = $contactRepository->find($contactId);
        $response = new ResponseContact();
        $response->setObject('Response : ' . $contact->getObject());
        $form = $this->createForm(ResponseType::class, $response);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $response->setSubmited(true);
            $response->setUser($this->security->getUser());
            $responseRepository->add($response, true);

            return $this->redirectToRoute('app_response_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/response/new.html.twig', [
            'contact' => $contact,
            'response' => $response,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_response_show", methods={"GET"})
     */
    public function show(ResponseContact $response): Response
    {
        return $this->render('back/response/show.html.twig', [
            'response' => $response,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_response_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ResponseContact $response, ResponseRepository $responseRepository): Response
    {
        $form = $this->createForm(ResponseType::class, $response);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $response->setSubmited(true);
            $response->setUser($this->security->getUser());
            $responseRepository->add($response, true);

            return $this->redirectToRoute('app_response_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/response/edit.html.twig', [
            'response' => $response,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_response_delete", methods={"POST"})
     */
    public function delete(Request $request, ResponseContact $response, ResponseRepository $responseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$response->getId(), $request->request->get('_token'))) {
            $responseRepository->remove($response, true);
        }

        return $this->redirectToRoute('app_response_index', [], Response::HTTP_SEE_OTHER);
    }
}
