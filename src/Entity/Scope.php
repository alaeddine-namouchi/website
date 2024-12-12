<?php

namespace App\Entity;

use App\Repository\ScopeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScopeRepository::class)
 */
class Scope
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $alias;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=ProfileScope::class, mappedBy="scope")
     */
    private $profileScopes;

    /**
     * @ORM\OneToMany(targetEntity=Content::class, mappedBy="scope")
     */
    private $contents;

    public function __construct()
    {
        $this->profileScopes = new ArrayCollection();
        $this->contents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, ProfileScope>
     */
    public function getProfileScopes(): Collection
    {
        return $this->profileScopes;
    }

    public function addProfileScope(ProfileScope $profileScope): self
    {
        if (!$this->profileScopes->contains($profileScope)) {
            $this->profileScopes[] = $profileScope;
            $profileScope->setScope($this);
        }

        return $this;
    }

    public function removeProfileScope(ProfileScope $profileScope): self
    {
        if ($this->profileScopes->removeElement($profileScope)) {
            // set the owning side to null (unless already changed)
            if ($profileScope->getScope() === $this) {
                $profileScope->setScope(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Content>
     */
    public function getContents(): Collection
    {
        return $this->contents;
    }

    public function addContent(Content $content): self
    {
        if (!$this->contents->contains($content)) {
            $this->contents[] = $content;
            $content->setScope($this);
        }

        return $this;
    }

    public function removeContent(Content $content): self
    {
        if ($this->contents->removeElement($content)) {
            // set the owning side to null (unless already changed)
            if ($content->getScope() === $this) {
                $content->setScope(null);
            }
        }

        return $this;
    }
}
