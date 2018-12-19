<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\InscriptionUserType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use  App\Entity\Account;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

     /**
     * @Route("/user_gestion", name="user_gestion")
     */
    public function user_gestion()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/user_gestion.html.twig');
    }

    /**
     * @Route("/user_inscription", name="user_inscription")
     */
    public function user_inscription(Request $request,ObjectManager $manager,UserPasswordEncoderInterface $encoder )
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user=new  Account();
         $inscriptionForm= $this->createForm(InscriptionUserType::class,$user);

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

        return $this->render('admin/user_inscription.html.twig',[
            'inscriptionUserForm'=>$inscriptionForm->createView(),
        ]);
    }
}
