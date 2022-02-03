<?php

namespace App\Controller;

use App\Entity\Word;
use App\Form\WordType;
use App\Repository\LexiconRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\WordRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/word", name="word_")
 */
class WordController extends AbstractController
{
    /**
     * @Route("", name="index")
     * @IsGranted("ROLE_USER")
     */
    public function index(WordRepository $repository): Response
    {
        $words = $repository->findAll();
        return $this->render('word/index.html.twig', ['words' => $words]);
    }

    /**
     * @Route("/add", name="new")
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $word = new Word();
        $form = $this->createForm(WordType::class, $word);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lexicon = $word->getLexicon();
            $entityManager->persist($word);
            $entityManager->flush();
            $this->addFlash('success', 'Mot ajouté avec succès');

            return $this->redirectToRoute('lexicon_show_content', ['id' => $lexicon->getId()]);
        }

        return $this->render('word/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Word $word, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WordType::class, $word);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Mot modifié avec succès');

            return $this->redirectToRoute('word_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('word/edit.html.twig', [
            'word' => $word,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Word $word): Response
    {

        return $this->render('word/show.html.twig', [
            'word' => $word,
        ]);
    }
    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Word $word, EntityManagerInterface $entityManager): Response
    {
        $lexicon = $word->getLexicon();
        if ($this->isCsrfTokenValid('delete' . $word->getId(), $request->request->get('_token'))) {
            $entityManager->remove($word);
            $entityManager->flush();
            $this->addFlash('success', 'Mot supprimé avec succès');
        }

        return $this->redirectToRoute('lexicon_show_content', ['id' => $lexicon->getId()], Response::HTTP_SEE_OTHER);
    }
}
