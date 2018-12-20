<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use  App\Entity\Account;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\InscriptionType;

class GatesController extends AbstractController
{

    /**
     * @Route("/", name="connexion")
     */
    public function connexion()
    {
        return $this->render('gates/index.html.twig');
    }




    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request,ObjectManager $manager,UserPasswordEncoderInterface $encoder )
    {
         $user=new  Account();
         $inscriptionForm= $this->createForm(InscriptionType::class,$user);

         $inscriptionForm->handleRequest($request);
         if($inscriptionForm->isSubmitted() && $inscriptionForm->isValid() )
         {
             $hash=$encoder->encodePassword($user,$user->getPassword());
             $user->setPassword($hash);
             $user->setRoles($user->getRoles());
             $user->setCreatedAt(new \DateTime('now'));
             $manager->persist($user);
             $manager->flush();
             return $this->redirectToRoute('user_profile');
         }

        return $this->render('gates/inscription.html.twig',[
            'inscriptionForm'=>$inscriptionForm->createView(),
        ]);
    }



    /**
     * @Route("/deconnexion",name="logout")
     */
    public function deconnexion(){}


    /**
     * @Route("/redirection", name="redirection")
     */
    public function redirection(Request $request)
    {
        if($this->isGranted('ROLE_DEVELOPER'))
        {
            return $this->redirectToRoute('developers');
        }
        else if($this->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute('admin');
        }

        else if($this->isGranted('ROLE_USER'))
        {
            return $this->redirectToRoute('user');
        }
        
        else
        {
            
            return $this->redirectToRoute('main');
        }
        
    }
}

    