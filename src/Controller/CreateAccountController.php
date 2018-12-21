<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class CreateAccountController extends AbstractController
{
    /**
     * @Route("/create/account", name="create")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $em)
    {
    	$user = new User();
    	
    	$form = $this->createForm(UserType::class, $user);
    	$form->handleRequest($request);
    	
    	if ($form->isSubmitted() && $form->isValid()){
    		
    		$hash = $encoder->encodePassword($user, $user->getPassword());
    		$user->setPassword($hash);
    		$user->setCreatedAt(new \DateTime());
    		
    		$em->persist($user);
    		$em->flush();
			
			return $this->redirectToRoute('app_login');
	    }
    	
        return $this->render('create_account/index.html.twig', [
            'form' => $form->createView(),
	        'retour' => true,
	        
        ]);
    }
    
    
}
