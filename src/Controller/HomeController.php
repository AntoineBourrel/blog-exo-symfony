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
        // Récupération des informations dans la bdd avec findBy
        $articles = $articleRepository->findBy([], ['id' => 'DESC'],3);

        // Vérification age
        if (($request->query->has('age')) && ($request->query->get('age') < 18))
        {
            return $this->render('error.html.twig');
            } else {
            return $this->render('home.html.twig',[
               'lastArticles' => array_reverse($articles)
            ]);
        }


    }
}