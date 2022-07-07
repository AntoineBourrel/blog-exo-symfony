<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class categoryController extends AbstractController
{
    //création de la route vers un category
    /**
     * @Route ("/category", name="category")
     */
    public function showCategory(CategoryRepository $CategoryRepository)
    {
        // La classe Repository me permet de faire des 'SELECT' dans la table associée
        // La méthode permet de récupérer un élément en fonction de son id
        $category = $CategoryRepository->find(1);
        dd($category);
    }
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