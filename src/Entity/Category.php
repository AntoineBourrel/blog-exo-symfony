<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotNull(message="t'as oublié le titre connard !")
     */
    // déclaration de la colonne title
    private $title;

    // Paramètre de la colonne color de la table Article, Type string qui devient Varchar 255
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="t'as oublié la couleur mongole !")
     */
    // déclaration de la colonne color
    private $color;

    // Paramètre de la colonne description de la table Article, Type text
    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotNull(message="t'as oublié la description tocard !")
     */
    // déclaration de la colonne description
    private $description;

    // Paramètre de la colonne isPublished de la table Article, Type booléens
    /**
     * @ORM\Column(type="boolean")
     */
    // déclaration de la colonne isPublished
    private $isPublished;

    // Relation Category à Article (OneToMany)
    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="category")
     */
    private $articles;
    // Constructeur qui créé un tableau vide
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

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCategory($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategory() === $this) {
                $article->setCategory(null);
            }
        }

        return $this;
    }





}
