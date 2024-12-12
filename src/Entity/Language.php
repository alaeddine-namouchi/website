<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LanguageRepository::class)
 */
class Language
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $alias;

    /**
     * @ORM\OneToMany(targetEntity=Menu::class, mappedBy="language")
     */
    private $menus;

    /**
     * @ORM\OneToMany(targetEntity=TimeLine::class, mappedBy="language")
     */
    private $timeLines;



    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->timeLines = new ArrayCollection();
 
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

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->setLanguage($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getLanguage() === $this) {
                $menu->setLanguage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TimeLine>
     */
    public function getTimeLines(): Collection
    {
        return $this->timeLines;
    }

    public function addTimeLine(TimeLine $timeLine): self
    {
        if (!$this->timeLines->contains($timeLine)) {
            $this->timeLines[] = $timeLine;
            $timeLine->setLanguage($this);
        }

        return $this;
    }

    public function removeTimeLine(TimeLine $timeLine): self
    {
        if ($this->timeLines->removeElement($timeLine)) {
            // set the owning side to null (unless already changed)
            if ($timeLine->getLanguage() === $this) {
                $timeLine->setLanguage(null);
            }
        }

        return $this;
    }

 

  

}
