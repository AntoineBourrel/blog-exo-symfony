<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    //création de la route vers une category
    /**
     * @Route ("/category/{id}", name="category")
     */
    public function showCategory(CategoryRepository $categoryRepository, $id)
    {
        // La classe Repository me permet de faire des 'SELECT' dans la table associée
        // La méthode permet de récupérer un élément en fonction de son id
        $category = $categoryRepository->find($id);
        return $this->render('show-category.html.twig', [
            'category' => $category
        ]);
    }
    //création de la route vers la liste de category
    /**
     * @Route ("/list-category", name="list_category")
     */
    public function listCategory(CategoryRepository $categoryRepository)
    {
        // La classe Repository me permet de faire des 'SELECT' dans la table associée
        // La méthode permet de récupérer tous les éléments d'une table
        $categories = $categoryRepository->findAll();
        return $this->render('list-category.html.twig', [
            'categories' => $categories
        ]);
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
        $category->setTitle("Le HTLM pour Mongoliens");
        $category->setColor("red");
        $category->setDescription("Le HTML n'est pas un language de programmation !");
        $category->setIsPublished(true);


        //Envoie vers la base de données avec persist qui finis avec son flush
        $entityManager->persist($category);
        $entityManager->flush();

        dd($category);

    }
}