<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 */
class Profile
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
    private $label;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $alias;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

     /**
     * @ORM\OneToMany(targetEntity=ProfilAction::class, mappedBy="profile")
     */
    private $profilActions;

    /**
     * @ORM\OneToMany(targetEntity=Admin::class, mappedBy="profile")
     */
    private $admins;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="profiles")
     */
    private $categories;

    public function __construct()
    {
        $this->admins = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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
     * @return Collection<int, Admin>
     */
    public function getAdmins(): Collection
    {
        return $this->admins;
    }

    public function addAdmin(Admin $admin): self
    {
        if (!$this->admins->contains($admin)) {
            $this->admins[] = $admin;
            $admin->setProfile($this);
        }

        return $this;
    }

    public function removeAdmin(Admin $admin): self
    {
        if ($this->admins->removeElement($admin)) {
            // set the owning side to null (unless already changed)
            if ($admin->getProfile() === $this) {
                $admin->setProfile(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection<int, ProfilAction>
     */
    public function getProfilActions(): Collection
    {
        return $this->profilActions;
    }

    public function addProfilAction(ProfilAction $profilAction): self
    {
        if (!$this->profilActions->contains($profilAction)) {
            $this->profilActions[] = $profilAction;
            $profilAction->setProfile($this);
        }

        return $this;
    }

    public function removeProfilAction(ProfilAction $profilAction): self
    {
        if ($this->profilActions->removeElement($profilAction)) {
            // set the owning side to null (unless already changed)
            if ($profilAction->getProfile() === $this) {
                $profilAction->setProfile(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
