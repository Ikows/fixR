<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request)
    {
    	$form = $this->createForm(ContactType::class);
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
	        'retour' => true,
        ]);
    }
}
