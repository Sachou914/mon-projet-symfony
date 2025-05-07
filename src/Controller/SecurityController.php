<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route("/login", name:"app_login")]
     
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // Récupérer les erreurs de connexion (si elles existent)
        $error = $authenticationUtils->getLastAuthenticationError();
        // Récupérer le dernier email (ancien username saisi)
        $lastEmail = $authenticationUtils->getLastUsername();

        // Passer les variables au template
        return $this->render('security/login.html.twig', [
            'error' => $error,
            'last_username' => $lastEmail,  // on passe l'email et non un username
        ]);
    }

    #[Route("/logout", name:"app_logout")]

    public function logout()
    {
        // Symfony gère automatiquement la déconnexion
        // Tu peux laisser cette méthode vide
    }
}
