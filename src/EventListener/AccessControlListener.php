<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use App\Entity\ProfilAction;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterfaceas;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AccessControlListener
{

    // protected $userManager;
    // protected $container;
    // private $session;

	// private $securityContext;
	

	// private $entityManager;
	

    // public function __invoke(InteractiveLoginEvent $event,  EntityManagerInterface $entityManager, SessionInterface $session): void
    // {
    //     $user = $event->getAuthenticationToken()->getUser();
    //     dump($user);
        
    //     $profil = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getUserIdentifier()])->getProfile();
    //     $profilActions = $entityManager->getRepository(ProfilAction::class)->findBy(['profil' => $profil->getId()]);
    //     $permessionRoutes = [];
    //     foreach ($profilActions as $profilAction)
    //     {
    //         $route = $profilAction->getAction()->getRoute();
    //         $permessionRoutes[$route] = $route;
    //     }
    //     // dump($permessionRoutes);
    //     // echo count($permessionRoutes);
    //     // die;
    //     $session->clear();
    //     $session->set('permession_routes', $permessionRoutes);  
       
        
    // }
}