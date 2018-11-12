<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Article;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog/{page}", requirements={"page"="\d+"}, name="blog_list")
     */
    public function list($page)
    {
        return $this->render('blog/index.html.twig', ['page' => $page]);
    }

// Symfony quête 4 : le routing avancé
// possibilité de placer : , defaults={"slug"="Article Sans Titre"} dans la route
    /**
     * @Route("/blog/{slug<^$|[a-z0-9](-*[a-z0-9])*$>}", name="blog_show")
     */
/*    Fonction désactivée pour la quête 7 afficher les catégories et leurs articles en passant par la route /blog
    public function show($slug)
    {
        if (empty($slug))
            $finalSlug = "Article Sans Titre";
        else {
            $replace = str_replace("-", " ", $slug);
            $finalSlug = ucwords($replace);
        }
        return $this->render('blog/show.html.twig', ['finalSlug' => $finalSlug]);
    }*/

    // Fonction quête 7 pour afficher les catégories et leurs articles
    /**
     * @Route("/blog/articles", name="blog_articles")
     */
    public function displayArticles()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $articleManager = $entityManager->getRepository(Article::class);
        $articles = $articleManager->findAll();

        return $this->render('blog/articles.html.twig', ['articles' => $articles]);
    }

}