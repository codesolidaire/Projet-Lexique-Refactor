<?php

namespace App\Controller;

use App\Entity\Lexicon;
use App\Form\LexiconType;
use App\Repository\WordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LexiconRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/lexicon", name="lexicon_")
 */
class LexiconController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(LexiconRepository $repository): Response
    {
        $lexicons = $repository->findAll();

        return $this->render('lexicon/index.html.twig', ['lexicons' => $lexicons]);
    }

    /**
     * @Route("/{id}/content", name="show_content")
     */
    public function showContent(int $id, Lexicon $lexicon, LexiconRepository $lexiconrepository): Response
    {
        $words = $lexicon->getWords();
        $lexicon = $lexiconrepository->findOneBy(['id' => $id]);

        return $this->render('word/index.html.twig', ['words' => $words, 'lexicon' => $lexicon]);
    }


    /**
     * @Route("/new", name="new")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
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

    /**
     * @Route("/{title}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Lexicon $lexicon, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LexiconType::class, $lexicon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Lexicon modifié avec succès');

            return $this->redirectToRoute('lexicon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lexicon/edit.html.twig', [
            'lexicon' => $lexicon,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{title}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Lexicon $lexicon, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $lexicon->getTitle(), $request->request->get('_token'))) {
            $entityManager->remove($lexicon);
            $entityManager->flush();
            $this->addFlash('success', 'Lexicon supprimé avec succès');
        }

        return $this->redirectToRoute('lexicon_index', [], Response::HTTP_SEE_OTHER);
    }
}
