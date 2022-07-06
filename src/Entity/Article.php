<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Article
{
    // Paramètre de la colonne Id de la table Article
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    // Création de la colonne Id
    public $id;

    // Paramètre de la colonne Title de la table Article
    /**
     * @ORM\Column(type="string")
     */
    // Création de la colonne Title
    public $title;

}