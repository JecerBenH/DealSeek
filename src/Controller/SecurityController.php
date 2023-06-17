<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        $user = $this->getUser();
        if($user->getRoles()[0]=='ROLE_ADMIN'){
            return $this->redirectToRoute('home');
        }else{return $this->redirectToRoute('app_login');}

    }
    /**
     * @Route("/", name="home",methods={"GET", "POST"})
     */
    public function home(AuthenticationUtils $authenticationUtils): Response
    {


         if ($this->getUser()) {
             $user = $this->getUser();
             if($user->getRoles()[0]=='ROLE_ADMIN'){return $this->redirectToRoute('admin_index');}
             return $this->redirectToRoute('reclam_index');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('homepage/index.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
}
