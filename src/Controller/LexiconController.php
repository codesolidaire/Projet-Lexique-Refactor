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
     */
    public function index(): Response
    {
        /* Controlleur accessible que par ce role:
         (https://symfony.com/doc/current/security.html#securing-controllers-and-other-code) */
        $this->denyAccessUnlessGranted('ROLE_USER');

        /** @var User | null $user */
        $user = $this->getUser();

        // recuperer le nom de l'user pour la vue
        $username = $user ? $user->getEmail() : null;

        // recuperer la liste des lexicons de l'user connecté
        $lexiconList = $user ? $user->getLexicons()  : null;

        return $this->render('lexicon/index.html.twig', ['lexiconList' => $lexiconList, 'username' => $username]);
    }
}
