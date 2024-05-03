<?php

namespace App\EventSubscriber;

use App\Entity\Admin;
use App\Entity\ProfilAction;
use App\Entity\Profile;
use App\Entity\ProfileScope;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Security;

class AccessControlEventSubscriber implements EventSubscriberInterface
{

    private $session;
    private $entityManager;
    /** @var \Symfony\Component\Security\Core\Security */
    private $security;


    /**
     * Constructor
     *
     * @param Security $security
     * @param EntityManagerInterface $entityManager
     * @param SessionInterface $session
     */
    public function __construct(
        Security               $security,
        EntityManagerInterface $entityManager,
        SessionInterface       $session
    )
    {

        $this->session = $session;
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $user = $this->security->getUser();
        if (isset($user)) {
            $user = $this->security->getUser();
            $profil = $this->entityManager->getRepository(Admin::class)->findOneBy(['email' => $user->getUserIdentifier()])->getProfile();
            $profilActions = $this->entityManager->getRepository(ProfilAction::class)->findBy(['profile' => $profil->getId()]);
            $permessionRoutes = [];
//            $profileScopes = $profil->getProfileScopes();
            $profileScopes = $this->entityManager->getRepository(ProfileScope::class)->findBy(['profile' => $profil->getId()]);

            foreach ($profilActions as $profilAction) {
                $route = $profilAction->getAction()->getRoute();
                $permessionRoutes[$route] = $route;
            }
            $permessionRoutes['app_gallery_load'] = 'app_gallery_load';
            
//             dd($profileScopes);
//             dd($profileScopes->getScope());
            // echo count($permessionRoutes);
            // die;
            //$this->session->clear();
            // dump($permessionRoutes);
            $this->session->set('permession_routes', $permessionRoutes);
            $this->session->set('profile_scopes', $profileScopes);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
