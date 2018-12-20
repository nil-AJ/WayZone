<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Delay;
use Symfony\Bridge\Twig\TokenParser\TransChoiceTokenParser;
use App\Entity\Transport;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $retard = $this->getDoctrine()->getRepository(Delay::class);
        $information = $this->getDoctrine()->getRepository(Transport::class);
        $retard=$retard->findAll();
        $information=$information->findAll();
        return $this->render('user/index.html.twig',[
            "retard"=>$retard,
            "information"=>$information
        ]);
    }

    /**
     * @Route("/user_profile", name="user_profile")
     */
    public function user_profile()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('user/user_profile.html.twig');
    }

}
