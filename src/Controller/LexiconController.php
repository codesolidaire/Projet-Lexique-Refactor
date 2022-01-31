<?php

namespace App\Controller;

use App\Repository\LexiconRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

/**
 * @Route("/lexicon", name="lexicon_")
 */
class LexiconController extends AbstractController
{
    /**
     * @Route("", name="index")
     * @IsGranted("ROLE_USER")
     */
    public function index(): Response
    {
        return $this->render('lexicon/index.html.twig');
    }
}
