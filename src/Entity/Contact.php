<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *  @ORM\Entity(repositoryClass=ContactRepository::class)
 *  @ORM\HasLifecycleCallbacks
 *  @Assert\EnableAutoMapping()
 */
class Contact
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
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="text")
     */
    private $object;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $emailAdress;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $mobileNumber;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $readAt;

    /**
     * @ORM\OneToMany(targetEntity=ContactTheme::class, mappedBy="contact")
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




    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getEmailAdress(): ?string
    {
        return $this->emailAdress;
    }

    public function setEmailAdress(string $emailAdress): self
    {
        $this->emailAdress = $emailAdress;

        return $this;
    }

    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    public function setMobileNumber(?string $mobileNumber): self
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getReadAt(): ?\DateTimeImmutable
    {
        return $this->readAt;
    }

    public function setReadAt(?\DateTimeImmutable $readAt): self
    {
        $this->readAt = $readAt;

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
            $contactTheme->setContact($this);
        }

        return $this;
    }

    public function removeContactTheme(ContactTheme $contactTheme): self
    {
        if ($this->contactThemes->removeElement($contactTheme)) {
            // set the owning side to null (unless already changed)
            if ($contactTheme->getContact() === $this) {
                $contactTheme->setContact(null);
            }
        }

        return $this;
    }
}
