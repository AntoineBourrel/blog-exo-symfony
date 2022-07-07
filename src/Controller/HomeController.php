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

    public function home(Request $request, ArticleRepository $articleRepository){

        $articles = $articleRepository->findAll();

        $articlesCount = count($articles);
        $lastArticles = array_reverse(array_slice($articles, ($articlesCount - 3)));


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