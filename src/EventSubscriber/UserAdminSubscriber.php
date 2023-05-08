<?php

namespace App\EventSubscriber;

use App\Entity\Admin;
use App\Entity\ProfilAction;
use App\Repository\AdminRepository;
use App\Repository\ProfilActionRepository;
use App\Repository\ProfileRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class UserAdminSubscriber implements EventSubscriberInterface
{
    private $session;
    private  $entityManager;
    /** @var \Symfony\Component\Security\Core\Security */
	private $security;
	
	
	/**
	 * Constructor
	 * 
	 * @param Security $security
     * @param EntityManagerInterface        $entityManager
     * @param SessionInterface        $session
	 */
	public function __construct(
                Security $security, 
                EntityManagerInterface $entityManager,  
                SessionInterface $session
                ){
        
        $this->session = $session;
		$this->security = $security;
        $this->entityManager = $entityManager;
	}
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $this->security->getUser();
        if(!isset($user)){
            return ;
        }
            $user = $this->security->getUser();
            $profil = $this->entityManager->getRepository(Admin::class)->findOneBy(['email' => $user->getUserIdentifier()])->getProfile();
            $profilActions = $this->entityManager->getRepository(ProfilAction::class)->findBy(['profile' => $profil->getId()]);
            $permessionRoutes = [];
            foreach ($profilActions as $profilAction)
            {
                $route = $profilAction->getAction()->getRoute();
                $permessionRoutes[$route] = $route;
            }
            // dd($permessionRoutes);
            // echo count($permessionRoutes);
            // die;
            $this->session->clear();
            $this->session->set('permession_routes', $permessionRoutes);  
        
    }

    public static function getSubscribedEvents()
    {
        return [
            'security.interactive_login' => 'onSecurityInteractiveLogin',
        ];
    }
}
