<?php

namespace App\Controller;

//use Doctrine\DBAL\Types\TextType;
use App\Form\ArticleType;
use App\Form\GetArticleByIdType;
use App\Form\SearchPriceType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
//use http\Env\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\GetArticleByNameType;

//use Symfony\Component\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @route("/article/new", name="article_create")
     * @route("/article/{id}/edit", name="article_edit")
     */
    public function form(Article $article = null, Request $request, EntityManagerInterface $manager){
        if(!$article){
            $article = new Article();
        }
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('articleShow',['id' => $article->getId()]);
        }

        return $this->render('article/create.html.twig', [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() != null
        ]);
    }

    /**
     * @route("/article/{id}/delete", name="article_delete")
     */
    public function delete(Article $article): RedirectResponse{
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute("article");

    }

    /**
     * @route("/search", name="article_search")
     */
    public function getArticleByName(Request $request)
    {

       $form = $this->createForm(GetArticleByNameType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $repo = $this->getDoctrine()->getRepository(Article::class);
            $article = $repo->findOneBy([ 'name' => $request->request->all('get_article_by_name') ]);
            if(!$article){
                $error = "Cet article n'existe pas !";
                return $this->render('article/searchByName.html.twig', [
                    'error' => $error
                ]);
            }
            return $this->render('article/searchByName.html.twig', [
                'article' => $article
            ]);
        }
        return $this->render('article/searchByName.html.twig', [
            'formArticle' => $form->createView()
        ]);
    }

    /**
     * @route("/searchid", name="article_searchId")
     */
    public function getArticleById(Request $request){

        $form = $this->createForm(GetArticleByIdType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $repo = $this->getDoctrine()->getRepository(Article::class);
            $article = $repo->findOneBy([ 'id' => $request->request->all('get_article_by_id') ]);
            if(!$article){
                $error = "Cet article n'existe pas !";
                return $this->render('article/searchById.html.twig', [
                    'error' => $error
                ]);
            }
            return $this->render('article/searchById.html.twig', [
                'article' => $article
            ]);
        }
        return $this->render('article/searchById.html.twig', [
            'formArticle' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @route("/searchprice", name="search_price")
     */

    public function articlesByPrice(Request $request){
        $form = $this->createForm(SearchPriceType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $parameters= $request->request->get('search_price');
            $minPrice = $parameters['minPrice'];
            $maxPrice = $parameters['maxPrice'];
            $repo = $this->getDoctrine()->getRepository(Article::class);
            $articles = $repo->findAllBetweenMinPriceAndMaxPrice($minPrice,$maxPrice);
            
            if(!$articles){
                $error = "Cet article n'existe pas !";
                return $this->render('article/searchPrice.html.twig', [
                    'error' => $error
                ]);
            }
            return $this->render('article/searchPrice.html.twig', [
                'controller_name' => 'ArticleController',
                'articles' => $articles
            ]);
        }
        return $this->render('article/searchPrice.html.twig', [
            'formArticle' => $form->createView()
        ]);

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
