<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

// Déclaration de création d'une class qui sera une entité via ORM
/**
 * @ORM\Entity()
 */
class Article
{
    // Paramètre de la colonne Id de la table Article, Type integer et auto-incrément
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    // déclaration de la colonne Id
    public $id;

    // Paramètre de la colonne Title de la table Article, Type string qui devient Varchar 255
    /**
     * @ORM\Column(type="string")
     */
    // déclaration de la colonne Title
    public $title;

    // Paramètre de la colonne Image de la table Article, Type string qui devient Varchar 255
    /**
     * @ORM\Column(type="string")
     */
    // déclaration de la colonne image
    public $image;

    // Paramètre de la colonne IsPublished de la table Article, Type booléen
    /**
     * @ORM\Column(type="boolean")
     */
    // déclaration de la colonne isPublished
    public $isPublished;

    // Paramètre de la colonne author de la table Article, Type string qui devient Varchar 255
    /**
     * @ORM\Column(type="string")
     */
    // déclaration de la colonne isPublished
    public $author;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publishedAt;

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

}

//créer la base de donnée
// php bin/console doctrine:database:create

//update de la table
// php bin/console make:migration
// si sucess
//php bin/console doctrine:migration:migrate

//Sinon par la console de commande
// php bin/console make:entity