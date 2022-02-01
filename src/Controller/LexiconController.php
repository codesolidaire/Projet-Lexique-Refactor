<?php

namespace App\Controller;

use App\Entity\Lexicon;
use App\Form\LexiconType;
use Gitonomy\Git\Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\LexiconRepository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @Route("/lexicon", name="lexicon_")
 */
class LexiconController extends AbstractController
{
    /**
     * @Route("", name="index")
     * @IsGranted("ROLE_USER")
     */
    public function index(LexiconRepository $repository): Response
    {
        $lexicons = $repository->findAll();

        return $this->render('lexicon/index.html.twig', ['lexicons' => $lexicons]);
    }

    /**
     * @Route("/add", name="new")
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lexicon = new Lexicon();
        $form = $this->createForm(LexiconType::class, $lexicon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Entity\User $user */
            $user = $this->getUser();
            $lexicon->setUser($user);
            $entityManager->persist($lexicon);
            $entityManager->flush();
            $this->addFlash('success', 'Lexicon ajouté avec succès');

            return $this->redirectToRoute('lexicon_index');
        }

        return $this->render('lexicon/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
