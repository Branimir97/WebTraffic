<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if(!$this->isGranted("ROLE_ADMIN")) {
            $error = $authenticationUtils->getLastAuthenticationError();
            $lastUsername = $authenticationUtils->getLastUsername();
            return $this->render('auth/login.html.twig',
            ['last_username' => $lastUsername, 'error' => $error]);
        } 
        return $this->redirectToRoute("admin");
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {}
}
