<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
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
