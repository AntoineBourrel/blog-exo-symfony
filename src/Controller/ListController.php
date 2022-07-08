<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ListController extends AbstractController
{
    //création de la route vers un article
    /**
     * @Route ("/article/{id}", name="article")
     */
    public function showArticle(ArticleRepository $articleRepository, $id)
    {
        // La classe Repository me permet de faire des 'SELECT' dans la table associée
        // La méthode permet de récupérer tous les éléments d'une table
        $article = $articleRepository->find($id);
        return $this->render('show_article.html.twig',[
            'article' => $article
        ]);
    }

    //création de la route vers la liste d'article
    /**
     * @Route ("/list", name="list")
     */
    public function listArticles(ArticleRepository $articleRepository)
    {
        // La classe Repository me permet de faire des 'SELECT' dans la table associée
        // La méthode permet de récupérer un élément en fonction de son id
        $articles = $articleRepository->findAll();
        return $this->render('list.html.twig',[
            'articles' => $articles
        ]);
    }

    // Création de la route insert-article
    /**
     * @Route ("/insert-article", name="insert_article")
     */
    // Méthode pour insérer un article dans la base de donnée
    // avec appel d'une instance de l'objet EntityMangerInterface
    public function insertArticle(EntityManagerInterface $entityManager)
    {

        // Appel d'une instance de l'objet Article et déclaration des paramètres de cette instance
        $article = new Article();
        $article->setTitle("Chat Mignon");
        $article->setContent("ouuuuh qu'il est ce petit chat ? Que je je lui roule dessus");
        $article->setIsPublished(true);
        $article->setImage('https://static.wamiz.com/images/upload/15876197_1368431473208290_144086124032163840_n(1).jpg');
        $article->setAuthor('Maurice');

        //Envoie vers la base de données avec persist qui finis avec son flush
        $entityManager->persist($article);
        $entityManager->flush();

        dd($article);
    }

    // déclaration de route vers la méthode 'articleDelete'
    /**
     * @Route ("/article/delete/{id}", name="article_delete")
     */
    public function articleDelete($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);
        // Je vérifie si $article est null
        if(!is_null($article)){
            //Je supprime $article de la bdd
            $entityManager->remove($article);
            $entityManager->flush();

            return new Response('Supprimé');
        }
        // Puisque $article est null, l'article à déjà était supprimé
        return new Response('Déjà Supprimé');

    }
    // Création de la route vers la méthode "articleUpdate"
    /**
     * @Route ("/article/update/{id}", name="article_update")
     */
    public function articleUpdate($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager){
        // Sélection de l'article en fonction de l'id
        $article = $articleRepository->find($id);
        // Valeurs de l'objet article à mettre à jour
        $article->setTitle("Chien Débile");
        // écriture en base de donnée
        $entityManager->persist($article);
        $entityManager->flush();

        return new Response('OK');
    }
}