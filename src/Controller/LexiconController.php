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
    private RequestStack $requestStack;

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
        $userId = $session->get('user_id');
        $lexiconList = $lexiconRepository->findBy(['user' => $userId]);

        return $this->render('lexicon/index.html.twig', ['lexiconList' => $lexiconList]);
    }
}
