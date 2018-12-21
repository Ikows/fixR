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
    public function index(Request $request, \Swift_Mailer $mailer)
    {
    	$form = $this->createForm(ContactType::class);
    	$form->handleRequest($request);
    	
    	if($form->isSubmitted() && $form->isValid()){
		    $mail = $request->request->get('contact');
    		$message = (new \Swift_Message($mail['Motif']))
			    ->setFrom('lloralik@gmail.com')
			    ->setTo($mail['Email'])
			    ->setBody($mail['Message']);
		    $mailer->send($message);

	    }
    	
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
	        'retour' => true,
        ]);
        
        
        
    }
}
