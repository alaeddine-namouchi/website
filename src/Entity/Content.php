<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContentRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @Assert\EnableAutoMapping()
 */
class Content
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $intro;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity=Admin::class, inversedBy="contents")
     */
    private $author_id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tags;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $published_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class)
     */
    private $language;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *  
     */
    private $published;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="contents")
     */
    private $article;

    // /**
    //  * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="contents")
    //  */
    // private $article;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtAutomatically()
    {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime('now'));
            $this->setUpdatedAt(new \DateTime('now'));
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtAutomatically()
    {
        $this->setUpdatedAt(new \DateTime('now'));
    }
    





    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getIntro(): ?string
    {
        return $this->intro;
    }

    public function setIntro(?string $intro): self
    {
        $this->intro = $intro;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getAuthorId(): ?Admin
    {
        return $this->author_id;
    }

    public function setAuthorId(?Admin $author_id): self
    {
        $this->author_id = $author_id;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getPublishedDate(): ?\DateTime 
    {
        return $this->published_date;
    }

    public function setPublishedDate(?\DateTime  $published_date): self
    {
        $this->published_date = $published_date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime 
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime  $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime 
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTime  $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    // public function getArticle(): ?Article
    // {
    //     return $this->article;
    // }

    // public function setArticle(?Article $article): self
    // {
    //     $this->article = $article;

    //     return $this;
    // }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }
}
