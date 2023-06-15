<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThemeRepository::class)
 */
class Theme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity=ContactTheme::class, mappedBy="theme")
     */
    private $contactThemes;

    public function __construct()
    {
        $this->contactThemes = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection<int, ContactTheme>
     */
    public function getContactThemes(): Collection
    {
        return $this->contactThemes;
    }

    public function addContactTheme(ContactTheme $contactTheme): self
    {
        if (!$this->contactThemes->contains($contactTheme)) {
            $this->contactThemes[] = $contactTheme;
            $contactTheme->setTheme($this);
        }

        return $this;
    }

    public function removeContactTheme(ContactTheme $contactTheme): self
    {
        if ($this->contactThemes->removeElement($contactTheme)) {
            // set the owning side to null (unless already changed)
            if ($contactTheme->getTheme() === $this) {
                $contactTheme->setTheme(null);
            }
        }

        return $this;
    }
}
