<?php

// src/Controller/RegistrationController.php
namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route("/register", name:"app_register")]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        // Création de l'entité utilisateur
        $user = new User();

        // Création du formulaire
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        // Vérification si le formulaire a été soumis
        if ($form->isSubmitted()) {
            // Vérification de la validité du formulaire après la soumission
            if ($form->isValid()) {
                // Encodage du mot de passe
                $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));

                // Enregistrement de l'utilisateur dans la base de données
                $entityManager->persist($user);
                $entityManager->flush();

                // Ajout d'un message flash
                $this->addFlash('success', 'Inscription réussie ! Veuillez vous connecter.');

                // Redirection vers la page de connexion après inscription
                return $this->redirectToRoute('app_login');
            } else {
                // Si le formulaire est invalide, ajouter un message d'erreur
                $this->addFlash('error', 'Veuillez corriger les erreurs dans le formulaire.');
            }
        }

        // Rendu du formulaire d'inscription
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
