<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @route("/article/new", name="article_create")
     */
    public function create(){
        return $this->render('article/create.html.twig');
    }

    /**
     * @Route("/article", name="article")
     */
    public function index(ArticleRepository $repo)
    {
       // $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(){
        return $this->render('article/home.html.twig');
    }

    /**
     * @route("/article/{id}", name="articleShow")
     */
    public function show(Article $article){
        //$repo = $this->getDoctrine()->getRepository(Article::class);
        //$article = $repo->find($id);
        return $this->render('article/show.html.twig',[
            'article' => $article
        ]);
    }


}
