<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class categoryController extends AbstractController
{
    // Création de la route insert-category
    /**
     * @Route ("/insert-category", name="insert_category")
     */
    // Méthode pour insérer une categorie dans la base de donnée
    // avec appel d'une instance de l'objet EntityMangerInterface
    public function insertCategory(EntityManagerInterface $entityManager){

        // Appel d'une instance de l'objet Category et déclaration des paramètres de cette instance
        $category = new Category();
        $category->setTitle("Le php c'est de la merde");
        $category->setColor("brown");
        $category->setDescription("Le php c'est de la grosse merde !");
        $category->setIsPublished(true);


        //Envoie vers la base de données avec persist qui finis avec son flush
        $entityManager->persist($category);
        $entityManager->flush();

        dd($category);

    }
}