<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="home_")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('home_index', ['_locale' => 'fr']);
    }

    /**
     * @Route("", name="index")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }
}
