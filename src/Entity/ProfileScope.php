<?php

namespace App\Entity;

use App\Repository\ProfileScopeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfileScopeRepository::class)
 */
class ProfileScope
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Profile::class, inversedBy="profileScopes")
     */
    private $profile;

    /**
     * @ORM\ManyToOne(targetEntity=Scope::class, inversedBy="profileScopes")
     */
    private $scope;

//    /**
//     * @ORM\ManyToOne(targetEntity=Profile::class)
//     */
//    private $scopes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function getScope(): ?Scope
    {
        return $this->scope;
    }

    public function setScope(?Scope $scope): self
    {
        $this->scope = $scope;

        return $this;
    }

    /*public function getScopes(): ?Profile
    {
        return $this->scopes;
    }

    public function setScopes(?Profile $scopes): self
    {
        $this->scopes = $scopes;

        return $this;
    }*/
}
