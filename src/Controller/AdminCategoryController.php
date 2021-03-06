<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    //création de la route vers une category
    /**
     * @Route ("/admin/category/{id}", name="admin_category")
     */
    public function showCategory(CategoryRepository $categoryRepository, $id)
    {
        // La classe Repository me permet de faire des 'SELECT' dans la table associée
        // La méthode permet de récupérer un élément en fonction de son id
        $category = $categoryRepository->find($id);
        return $this->render('Admin/show-category.html.twig', [
            'category' => $category
        ]);
    }
    //création de la route vers la liste de category
    /**
     * @Route ("/admin/list-category", name="admin_list_category")
     */
    public function listCategory(CategoryRepository $categoryRepository)
    {
        // La classe Repository me permet de faire des 'SELECT' dans la table associée
        // La méthode permet de récupérer tous les éléments d'une table
        $categories = $categoryRepository->findAll();
        return $this->render('Admin/list-category.html.twig', [
            'categories' => $categories
        ]);
    }

    // Création de la route insert-category
    /**
     * @Route ("/admin/insert-category", name="admin_insert_category")
     */
    // Méthode pour insérer une categorie dans la base de donnée
    // avec appel d'une instance de l'objet EntityMangerInterface
    public function insertCategory(EntityManagerInterface $entityManager, Request $request){

        // Création nouvelle instance de Category
        $category = new Category();
        $category->setIsPublished(true);
        // Création d'un formulaire lié à la table Category via ses paramètres lié à l'instance de Category
        $form = $this->createForm(CategoryType::class, $category);

        // On donne la variable form une instance de Request pour que le formulaire puisse
        // récupérer les données et les traiter automatiquement
        $form->handleRequest($request);

        // Si le formulaire à été posté et que les données sont valides, on envoie sur la base de données
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success', 'Vous avez bien ajouté votre catégorie');
        }

        return $this->render('Admin/insert-category.html.twig', [
            // Utilisation de la méthode createView pour créer la view du formulaire
            'form' => $form->createView()
        ]);

        /* // Récupération des valeurs du formulaire
        $title = $request->query->get('title');
        $color = $request->query->get('color');

        // Vérification si les valeurs 'get' existe
        if($request->query->has('title') && $request->query->has('color')){
            // Vérification si les valeurs 'get' sont vides
            if (!empty($title) &&
                !empty($color)
            ) {
                // Création d'une instance de l'objet Category et déclaration des paramètres de cette instance
                $category = new Category();
                $category->setTitle($title);
                $category->setColor($color);
                $category->setIsPublished(true);

                //Envoie vers la base de données avec persist qui finis avec son flush
                $entityManager->persist($category);
                $entityManager->flush();
                $this->addFlash('success', 'Vous avez bien ajouté votre catégorie');
                return $this->redirectToRoute('admin_list_category');
            }
            // Erreur en cas de valeurs vide
            $this->addFlash('error', 'Merci de remplir le titre et la couleur!');
            return $this->render('admin/insert-category.html.twig');
        }
        // Si les valeurs n'existe pas, affichage de la page du formulaire
        return $this->render('Admin/insert-category.html.twig'); */
    }

    // déclaration de route vers la méthode 'categoryDelete'
    /**
     * @Route ("/admin/category/delete/{id}", name="admin_category_delete")
     */
    public function categoryDelete($id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        $category = $categoryRepository->find($id);
        // Je vérifie si $category est null
        if(!is_null($category)){
            //Je supprime $category de la bdd
            $entityManager->remove($category);
            $entityManager->flush();

            $this->addFlash('success', 'Vous avez bien supprimé votre catégorie');
            return $this->redirectToRoute('admin_list_category');
        }
        // Puisque $article est null, la category à déjà était supprimé
        $this->addFlash('error', 'catégorie introuvable');
        return $this->redirectToRoute('admin_list_category');
    }

    // Création de la route vers la méthode "categoryUpdate"
    /**
     * @Route ("/admin/category/update/{id}", name="admin_category_update")
     */
    public function categoryUpdate($id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager, Request $request)
    {
        // Création nouvelle instance de Category
        $category = new Category();
        $category->setIsPublished(true);
        // Création d'un formulaire lié à la table Category via ses paramètres lié à l'instance de Category
        $form = $this->createForm(CategoryType::class, $category);

        // On donne la variable form une instance de Request pour que le formulaire puisse
        // récupérer les données et les traiter automatiquement
        $form->handleRequest($request);

        // Si le formulaire à été posté et que les données sont valides, on envoie sur la base de données
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success', 'Vous avez bien ajouté votre catégorie');
        }

        return $this->render('Admin/category-update.html.twig', [
            // Utilisation de la méthode createView pour créer la view du formulaire
            'form' => $form->createView()
        ]);




        /*// Sélection de l'article en fonction de l'id
        $category = $categoryRepository->find($id);
        // Récupération des valeurs du formulaire
        $title = $request->query->get('title');
        $color = $request->query->get('color');
        $description = $request->query->get('description');

        // Vérification si les valeurs 'get' existe
        if($request->query->has('title') && $request->query->has('color')){
            // Vérification si les valeurs 'get' sont vides
            if (!empty($title) &&
                !empty($color)
            ) {
                // Valeurs de l'objet category à mettre à jour
                $category->setTitle($title);
                $category->setColor($color);
                $category->setDescription($description);
                // écriture en base de donnée
                $entityManager->persist($category);
                $entityManager->flush();
                // retour sur la page de liste de catégories
                $this->addFlash('success', 'Vous avez bien modifié votre catégorie');
                return $this->redirectToRoute('admin_list_category');
            } else {
                // Erreur en cas de valeurs vide
                $this->addFlash('error', 'Merci de remplir le titre et la couleur!');
                return $this->redirectToRoute('admin_list_category');
            }
        }
        // Si les valeurs n'existe pas, affichage de la page du formulaire
        return $this->render('Admin/category-update.html.twig', [
            'category' => $category
        ]); */

    }
}