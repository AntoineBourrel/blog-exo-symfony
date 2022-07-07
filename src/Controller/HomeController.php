<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    // Création de la route vers l'accueil
    /**
     * @Route ("/", name="home")
     */
    // Méthode pour récupérer les articles dans la bdd + traitement formulaire d'age
    public function home(Request $request, ArticleRepository $articleRepository){
        // Récupération des informations dans la bdd
        $articles = $articleRepository->findAll();
        // Traitement pour n'avoir que les 3 derniers articles de la bdd
        $articlesCount = count($articles);
        $lastArticles = array_reverse(array_slice($articles, ($articlesCount - 3)));

        // Vérification age + condition en fonction du nombre d'articles dans la bdd
        if (($request->query->has('age')) && ($request->query->get('age') < 18)) {
            return $this->render('error.html.twig');
        } else {
            if($articlesCount <= 3){
                return $this->render('home.html.twig',[
                   'lastArticles' => array_reverse($articles)
                ]);
            }else{
                return $this->render('home.html.twig', [
                    'lastArticles' => $lastArticles
                ]);
            }

        }

    }
}