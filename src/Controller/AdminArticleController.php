<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminArticleController extends AbstractController
{
    //création de la route vers un article
    /**
     * @Route ("/admin/show-article/{id}", name="admin_article")
     */
    public function showArticle(ArticleRepository $articleRepository, $id)
    {
        // La classe Repository me permet de faire des 'SELECT' dans la table associée
        // La méthode permet de récupérer tous les éléments d'une table
        $article = $articleRepository->find($id);
        return $this->render('Admin/show-article.html.twig',[
            'article' => $article
        ]);
    }

    //création de la route vers la liste d'article
    /**
     * @Route ("/admin/list", name="admin_list")
     */
    public function listArticles(ArticleRepository $articleRepository)
    {
        // La classe Repository me permet de faire des 'SELECT' dans la table associée
        // La méthode permet de récupérer un élément en fonction de son id
        $articles = $articleRepository->findAll();
        return $this->render('Admin/list.html.twig',[
            'articles' => $articles
        ]);
    }

    // Création de la route insert-article
    /**
     * @Route ("/admin/insert-article", name="admin_insert_article")
     */
    // Méthode pour insérer un article dans la base de donnée
    // avec appel d'une instance de l'objet EntityMangerInterface
    public function insertArticle(EntityManagerInterface $entityManager, Request $request)
    {
        // Création nouvelle instance d'Article
        $article = new Article();
        $article->setIsPublished(true);
        // Création d'un formulaire lié à la table Article via ses paramètres lié à l'instance d'Article
        $form = $this->createForm(ArticleType::class, $article);

        // On donne la variable form une instance de Request pour que le formulaire puisse
        // récupérer les données et les traiter automatiquement
        $form->handleRequest($request);

        // Si le formulaire à été posté et que les données sont valides, on envoie sur la base de données
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success', 'Vous avez bien ajouté votre article');
        }

        return $this->render('Admin/insert-article.html.twig', [
            // Utilisation de la méthode createView pour créer la view du formulaire
            'form' => $form->createView()
        ]);

        /* // Récupération des valeurs du formulaire
        $title = $request->query->get('title');
        $content = $request->query->get('content');
        $image = $request->query->get('image');
        $author = $request->query->get('author');

        // Vérification si les valeurs 'get' existe
        if($request->query->has('title') &&
            $request->query->has('content') &&
            $request->query->has('image') &&
            $request->query->has('author'))
        {
            // Vérification si les valeurs 'get' sont vides
            if (!empty($title) &&
                !empty($content) &&
                !empty($image) &&
                !empty($author)
            ) {
                // Création d'une instance de l'objet Article et déclaration des paramètres de cette instance
                $article = new Article();
                $article->setTitle($title);
                $article->setContent($content);
                $article->setImage($image);
                $article->setAuthor($author);
                $article->setIsPublished(true);


                //Envoie vers la base de données avec persist qui finis avec son flush
                $entityManager->persist($article);
                $entityManager->flush();

                $this->addFlash('success', 'Vous avez bien ajouté votre article');

                return $this->redirectToRoute('admin_list');
            }
            // Erreur en cas de valeurs vide
            $this->addFlash('error', 'Merci de remplir les champs ci-dessous');
            return $this->render('admin/insert-article.html.twig');
        }
        // Si les valeurs n'existe pas, affichage de la page du formulaire
        return $this->render('Admin/insert-article.html.twig'); */
    }

    // déclaration de route vers la méthode 'articleDelete'
    /**
     * @Route ("/admin/article/delete/{id}", name="admin_article_delete")
     */
    public function articleDelete($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);
        // Je vérifie si $article est null
        if(!is_null($article)){
            //Je supprime $article de la bdd
            $entityManager->remove($article);
            $entityManager->flush();

            $this->addFlash('success', 'Vous avez bien supprimé votre article');
            return $this->redirectToRoute('admin_list');
        }
        // Puisque $article est null, l'article à déjà était supprimé
        $this->addFlash('error', 'Article introuvable');
        return $this->redirectToRoute('admin_list');

    }
    // Création de la route vers la méthode "articleUpdate"
    /**
     * @Route ("/admin/article/update/{id}", name="admin_article_update")
     */
    public function articleUpdate($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager, Request $request)
    {
        // Création nouvelle instance d'Article
        $article = new Article();
        $article->setIsPublished(true);
        // Création d'un formulaire lié à la table Article via ses paramètres lié à l'instance d'Article
        $form = $this->createForm(ArticleType::class, $article);

        // On donne la variable form une instance de Request pour que le formulaire puisse
        // récupérer les données et les traiter automatiquement
        $form->handleRequest($request);

        // Si le formulaire à été posté et que les données sont valides, on envoie sur la base de données
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success', 'Vous avez bien ajouté votre article');
        }

        return $this->render('Admin/article-update.html.twig', [
            // Utilisation de la méthode createView pour créer la view du formulaire
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route ("/admin/article/search", name="admin_article_search")
     */
    public function articleSearch(Request $request, ArticleRepository $articleRepository)
    {
        // Récupération valeur GET dans l'URL
        $search = $request->query->get('search');

        // je vais créer une méthode dans l'ArticleRepository
        // qui trouve un article en fonction d'un mot dans son titre ou son contenu
        $articles = $articleRepository->searchByWord($search);


        // Renvoie vers le fichier twig
        return $this->render('admin/search-article.html.twig', [
            'articles' => $articles
        ]);
    }
}