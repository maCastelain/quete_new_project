<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
    /**
     * @Route("/blog/{slug<^$|[a-z0-9](-*[a-z0-9])*$>}", name="blog_show")
     */
    public function show($slug)
    {
        if (empty($slug))
            $finalSlug = "Article Sans Titre";
        else {
            $replace = str_replace("-", " ", $slug);
            $finalSlug = ucwords($replace);
        }
        return $this->render('blog/show.html.twig', ['finalSlug' => $finalSlug]);
    }
}