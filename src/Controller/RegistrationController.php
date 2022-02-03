<?php

namespace App\Controller;

use App\Entity\Lexicon;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        // Hash du pass
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            // => Enregistrement de l'user dans la base de donnée
            $entityManager->persist($user);
            $entityManager->flush();

            // => Sauvegarde d'un lexique par défault, avec comme titre son Username
            $lexicon = new Lexicon();

            $lexicon->setTitle("lexique");
            $lexicon->setUser($user);

            // => Enregistrement du lexique dans la BDD
            $entityManager->persist($lexicon);
            $entityManager->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
