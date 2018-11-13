<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;


class BlogController extends AbstractController
{
    /**
     * Show all row from article's entity
     *
     * @Route("/blog", name="blog_index")
     * @return Response A response instance
     */
    public function index() : Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        return $this->render(
            'blog/index.html.twig',
            ['articles' => $articles]
        );
    }

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

    /**
     * @Route("/blog/{page}", requirements={"page"="\d+"}, name="blog_list")
     */
    public function list($page)
    {
        return $this->render('blog/index.html.twig', ['page' => $page]);
    }

    /**
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/blog/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="blog_show")
     *  @return Response A response instance
     */
    public function show($slug) : Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with ' . $slug . ' title, found in article\'s table.'
            );
        }

        return $this->render(
            'blog/show.html.twig',
            [
                'article' => $article,
                'slug' => $slug,
            ]
        );
    }
}