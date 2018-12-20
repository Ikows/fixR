<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Reaction;
use App\Form\ReactionType;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
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
        $form = $this->createForm(ReactionType::class, $reaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $reaction->setUser($user)
                ->setArticle($article)
                ->setCreatedAt(new \DateTime());
            $manager->persist($reaction);
            $manager->flush();

            unset($reaction);
            unset($form);
            $reaction = new Reaction();
            $form = $this->createForm(ReactionType::class, $reaction);
        }

        return $this->render('debat/index.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }
}
