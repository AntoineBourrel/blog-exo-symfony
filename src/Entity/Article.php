<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

// Déclaration de création d'une class qui sera une entité via ORM
/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    // Paramètre de la colonne Id de la table Article, Type integer et auto-incrément
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    // déclaration de la colonne Id
    private $id;

    // Paramètre de la colonne title de la table Article, Type string qui devient Varchar 255
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="t'as oublié le titre connard !")
     */
    // déclaration de la colonne title
    private $title;

    // Paramètre de la colonne image de la table Article, Type string qui devient Varchar 255
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="t'as oublié l'image patate !")
     */
    // déclaration de la colonne image
    private $image;

    // Paramètre de la colonne IsPublished de la table Article, Type booléen
    /**
     * @ORM\Column(type="boolean")
     */
    // déclaration de la colonne isPublished
    private $isPublished;

    // Paramètre de la colonne image de la table Article, Type string qui devient Varchar 255
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="t'as oublié l'autheur mongole !")
     */
    // déclaration de la colonne author
    private $author;

    // Paramètre de la colonne content de la table Article, Type text
    /**
     * @ORM\Column(type="text")
     * @Assert\NotNull(message="t'as oublié le contenu petit con !")
     */
    // déclaration de la colonne content
    private $content;

    // Création de la Foreign key reliant Article et Category (ManyToOne)
    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="articles")
     */
    private $category;



    // GETTER et SETTER des attributs de la class Article
    public function getId(): ?int
    {
        return $this->id;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function isIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }


    public function getCategory()
    {
        return $this->category;
    }


    public function setCategory($category): void
    {
        $this->category = $category;
    }


}
