<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(ArticleRepository $repository)
    {
        $articles = $repository -> findAll();

        return $this->render('dashboard/index.html.twig', [
            'articles' => $articles
        ]);
    }
}
