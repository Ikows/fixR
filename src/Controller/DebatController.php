<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DebatController extends AbstractController
{
    /**
     * @Route("/debat/{id}", name="debat")
     */
    public function index(Article $article): Response
    {

        return $this->render('debat/index.html.twig', [
            'article' => $article
        ]);
    }
}
