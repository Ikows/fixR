<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Reaction;
use App\Form\ReactionType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DebatController extends AbstractController
{
    /**
     * @Route("/debat/{id}", name="debat")
     */
    public function index(Article $article, Request $request, ObjectManager $manager): Response
    {

        $user = $this->getUser();
        $reaction = new Reaction();
        $reactionForm = $this->createForm(ReactionType::class, $reaction);
        $reactionForm->handleRequest($request);

        if ($reactionForm->isSubmitted() and $reactionForm->isValid()){
            $reaction->setUser($user)
                ->setCreatedAt(new \DateTime())
                ->setArticle($article);
            $manager->persist($reaction);
            $manager->flush();

            $this->redirectToRoute('debat', [
                'id' => $article->getId()
            ]);
        }

        return $this->render('debat/index.html.twig', [
            'article' => $article,
            'reactionForm' => $reactionForm->createView()
        ]);
    }
}
