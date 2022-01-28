<?php

namespace App\Controller;

use App\Repository\LexiconRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lexicon", name="lexicon_")
 */
class LexiconController extends AbstractController
{    
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("", name="index")
     */
    public function index(LexiconRepository $lexiconRepository): Response
    {
        $session = $this->requestStack->getSession();
        $user_id = $session->get('user_id');
        //$user_name = $session->get('user_name');
        //dd($user_name);
        $lexiconList = $lexiconRepository->findBy(['user'=>$user_id]);
        //dd($lexiconList);
        return $this->render('lexicon/index.html.twig', ['lexiconList' => $lexiconList]);
    }
}
