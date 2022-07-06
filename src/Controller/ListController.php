<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ListController extends AbstractController
{
    // Création de la route vers la liste d'article
    /**
     * @route ("/list", name="list")
     */


    public function list(){

        $articles = [
            1 => [
                'title' => 'Non, là c\'est sale',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Eric',
                'image' => 'https://media.gqmagazine.fr/photos/5b991bbe21de720011925e1b/master/w_780,h_511,c_limit/la_tour_montparnasse_infernale_1893.jpeg',
                'id' => 1
            ],
            2 => [
                'title' => 'Il faut trouver tous les gens qui étaient de dos hier',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Maurice',
                'image' => 'https://fr.web.img6.acsta.net/r_1280_720/medias/nmedia/18/35/18/13/18369680.jpg',
                'id' => 2
            ],
            3 => [
                'title' => 'Pluuutôôôôt Braaaaaach, Vasarelyyyyyy',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Didier',
                'image' => 'https://media.gqmagazine.fr/photos/5eb02109566df9b15ae026f3/master/pass/n-3freres.jpg',
                'id' => 3
            ],
            4 => [
                'title' => 'Quand on attaque l\'empire, l\'empire contre attaque',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Mbala',
                'image' => 'https://fr.web.img2.acsta.net/newsv7/21/01/20/15/49/5077377.jpg',
                'id' => 4
            ],
        ];

        return $this->render('list.html.twig', [
            'articles' => array_reverse($articles)
        ]);
    }

    // Création route vers les articles
    /**
     * @route ("/article/{id}", name="article")
     */

    public function article($id){
        $articles = [
            1 => [
                'title' => 'Non, là c\'est sale',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Eric',
                'image' => 'https://media.gqmagazine.fr/photos/5b991bbe21de720011925e1b/master/w_780,h_511,c_limit/la_tour_montparnasse_infernale_1893.jpeg',
                'id' => 1
            ],
            2 => [
                'title' => 'Il faut trouver tous les gens qui étaient de dos hier',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Maurice',
                'image' => 'https://fr.web.img6.acsta.net/r_1280_720/medias/nmedia/18/35/18/13/18369680.jpg',
                'id' => 2
            ],
            3 => [
                'title' => 'Pluuutôôôôt Braaaaaach, Vasarelyyyyyy',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Didier',
                'image' => 'https://media.gqmagazine.fr/photos/5eb02109566df9b15ae026f3/master/pass/n-3freres.jpg',
                'id' => 3
            ],
            4 => [
                'title' => 'Quand on attaque l\'empire, l\'empire contre attaque',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet assumenda deserunt eius eveniet molestias necessitatibus non, quos sed sequi! Animi aspernatur assumenda earum laudantium odio quasi quibusdam quisquam veniam.',
                'publishedAt' => new \DateTime('NOW'),
                'isPublished' => true,
                'author' => 'Mbala',
                'image' => 'https://fr.web.img2.acsta.net/newsv7/21/01/20/15/49/5077377.jpg',
                'id' => 4
            ],
        ];

        return $this->render('show_article.html.twig', [
            'article' => $articles[$id]
        ]);
    }

    // Création de la route insert-article
    /**
     * @Route ("/insert-article", name="insert_article")
     */
    // Méthode pour insérer un article dans la base de donnée
    // avec appel d'une instance de l'objet EntityMangerInterface
    public function insertArticle(EntityManagerInterface $entityManager){

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
}