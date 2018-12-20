<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/addafter", name="main")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/propos", name="propos")
     */
    public function propos()
    {
        return $this->render('main/propos.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('main/contact.html.twig');
    }

    /**
     * @Route("/projet", name="projet")
     */
    public function projet()
    {
        return $this->render('main/projet.html.twig');
    }
}
