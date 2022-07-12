<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
     */
    // déclaration de la colonne title
    private $title;

    // Paramètre de la colonne title de la table Article, Type string qui devient Varchar 255
    /**
     * @ORM\Column(type="string", length=255)
     */
    // déclaration de la colonne color
    private $color;

    // Paramètre de la colonne title de la table Article, Type text
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    // déclaration de la colonne description
    private $description;

    // Paramètre de la colonne title de la table Article, Type booléens
    /**
     * @ORM\Column(type="boolean")
     */
    // déclaration de la colonne isPublished
    private $isPublished;

    // Création de la foreign key reliant Category à Articles
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="category")
     */

    private $articles;
    // Constructeur créant un array dès la création d'une instance de category.articles
    public function __construct()
    {
       $this->articles = new ArrayCollection();
    }


    // GETTER et SETTER des attributs de la class Category
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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

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

    public function isIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }


    public function getArticles()
    {
        return $this->articles;
    }


    public function setArticles($articles)
    {
        $this->articles = $articles;
    }


}
