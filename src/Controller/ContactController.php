<?php

namespace App\Controller;

use App\Model\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * @Route("/contact", name="contact_")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from($contact->getEmail())
                ->to('contact@lexicon.com')
                ->subject($contact->getTitle())
                ->text($contact->getMessage());

            $mailer->send($email);
            $this->addFlash('success', 'Votre email a bien été envoyé');
            return $this->redirectToRoute('home_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('contact/index.html.twig', ['form' => $form->createView()]);
    }
}
