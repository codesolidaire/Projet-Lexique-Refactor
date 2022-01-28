<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    private $requestStack;
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    /**
     * @Route("", name="index")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(): Response
    {      
/*
        // Enregister dans la session l'user id         
        $user = new User;

        $session = $this->requestStack->getSession();
        $session->set('user_id', $user->getId())
        
        dd($session->set('user_id', $user->getId())); */

        return $this->render('user/login.html.twig');
    }
}
