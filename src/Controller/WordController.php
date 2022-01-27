<?php

namespace App\Controller;

use App\Entity\Word;
use App\Form\WordType;
use Gitonomy\Git\Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\WordRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/word", name="word_")
 */
class WordController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(WordRepository $repository): Response
    {
        $words = $repository->findAll();
        return $this->render('word/index.html.twig', ['words' => $words]);
    }
    /**
     * @Route("/add", name="form")
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $word = new Word();
        $form = $this->createForm(WordType::class, $word);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($word);
            $entityManager->flush();

            return $this->redirectToRoute('word_index');
        }

        return $this->render('word/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
