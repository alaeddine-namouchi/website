<?php

namespace App\Entity;
use Doctrine\Common\Collections\Collection;
use App\Repository\ActionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActionRepository::class)
 */
class Action
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
     * @ORM\Column(type="string", length=255)
     */
    private $route;

    /**
     * @ORM\ManyToOne(targetEntity=Section::class, inversedBy="actions")
     */
    private $section;

    /**
     * @ORM\ManyToOne(targetEntity=ActionType::class, inversedBy="actions")
     */
    private $actionType;

    /**
     * @ORM\ManyToOne(targetEntity=Action::class, inversedBy="actions")
     */
    private $action;


    /**
     * @ORM\OneToMany(targetEntity=Action::class, mappedBy="action")
     */
    private $actions;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $businessName;

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

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }

    public function getActionType(): ?ActionType
    {
        return $this->actionType;
    }

    public function setActionType(?ActionType $actionType): self
    {
        $this->actionType = $actionType;

        return $this;
    }

    public function getAction(): ?self
    {
        return $this->action;
    }

    public function setAction(?self $action): self
    {
        $this->action = $action;

        return $this;
    }

     /**
     * @return Collection<int, self>
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(self $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
            $action->setAction($this);
        }

        return $this;
    }

    public function removeAction(self $action): self
    {
        if ($this->actions->removeElement($action)) {
            // set the owning side to null (unless already changed)
            if ($action->getAction() === $this) {
                $action->setAction(null);
            }
        }

        return $this;
    }

    public function getBusinessName(): ?string
    {
        return $this->businessName;
    }

    public function setBusinessName(?string $businessName): self
    {
        $this->businessName = $businessName;

        return $this;
    }
}
