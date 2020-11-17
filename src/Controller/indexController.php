<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class indexController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function home()
    {
        return $this->render('home/index.html.twig');
    }
}
