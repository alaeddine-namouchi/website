<?php

namespace App\Entity;

use App\Repository\ProfilActionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfilActionRepository::class)
 */
class ProfilAction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Profile::class, inversedBy="profilActions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $profile;

    /**
     * @ORM\ManyToOne(targetEntity=Action::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $action;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfile(): ?Profile
    {
        return $this->getProfile();
    }

    public function setProfile(?Profile $profil): self
    {
        $this->profile = $profil;

        return $this;
    }

    public function getAction(): ?Action
    {
        return $this->action;
    }

    public function setAction(?Action $action): self
    {
        $this->action = $action;

        return $this;
    }
}
