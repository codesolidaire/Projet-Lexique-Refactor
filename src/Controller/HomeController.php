<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/", name="home_")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(Request $request): Response
    {
        if (count($request->cookies) > 0 )
        {
            return $this->redirectToRoute('login');
        } else {
           return $this->redirectToRoute('lexicon_index');
        }
    }
}
