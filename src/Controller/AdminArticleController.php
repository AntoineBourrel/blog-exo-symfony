<?php

namespace App\Controller;

use App\Entity\Article;
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
     * @Route ("/admin/article/{id}", name="admin_article")
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

        $title = $request->query->get('title');
        $content = $request->query->get('content');
        $image = $request->query->get('image');
        $author = $request->query->get('author');

        if($request->query->has('title') &&
            $request->query->has('content') &&
            $request->query->has('image') &&
            $request->query->has('author'))
        {
            if (!empty($title) &&
                !empty($content)
            ) {
                // Appel d'une instance de l'objet Article et déclaration des paramètres de cette instance
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
            $this->addFlash('error', 'Merci de remplir les champs ci-dessous');
            return $this->render('admin/insert-article.html.twig');
        }
        return $this->render('Admin/insert-article.html.twig');
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
    public function articleUpdate($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager){
        // Sélection de l'article en fonction de l'id
        $article = $articleRepository->find($id);
        // Valeurs de l'objet article à mettre à jour
        $article->setTitle("Chien Débile");
        $article->setContent("le chien qui fait de rantanplan un génie ! C'est dire !");
        $article->setImage('https://i.skyrock.net/9594/31129594/pics/1360366600_small.jpg');
        $article->setAuthor('Philippe');
        // écriture en base de donnée
        $entityManager->persist($article);
        $entityManager->flush();
        // retour sur la page de liste d'articles
        $this->addFlash('success', 'Vous avez bien modifié votre article');
        return $this->redirectToRoute('admin_list');
    }
}