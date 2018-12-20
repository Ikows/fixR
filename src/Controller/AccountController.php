<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\JournalistType;
use App\Form\ProfileEditionType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index()
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    /**
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/create/journalist", name="create_journalist")
     */
    public function createJournalist(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(JournalistType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user -> setPassword($hash);
            $user->setCreatedAt(new \DateTime());

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte a bien été créé"
            );

            return $this->redirectToRoute("homepage");
        }


        return $this->render('account/creationJournalist.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/profile/journalist/{slug}", name="profile_journalist")
     */
    public function profileJournalist(User $user)
    {
        return $this->render('account/profileJournalist.html.twig',[
            'user' => $user
        ]);
    }

    /**
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/edit/journalist", name="edit_journalist")
     */
    public function editProfileJournalist(Request $request, ObjectManager $manager)
    {
        $user = $this->getUser();

        $form = $this->createForm(ProfileEditionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setCreatedAt(new \DateTime());

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre profil a bien été mis à jour"
            );
        }

        return $this->render('account/editProfileJournalist.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
