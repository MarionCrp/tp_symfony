<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use sil16\VitrineBundle\Entity\Customer;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
    // CONNEXION
    public function logInAction(Request $request) {

        if($this->getUser()){
          $this->addFlash('success', "Vous êtes déjà connecté");
          return $this->redirect($this->generateUrl('sil16_vitrine_accueil'));
        }

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastEmail = $authenticationUtils->getLastUsername();

        return $this->render('sil16VitrineBundle:Security:login.html.twig', array(
            'last_email' => $lastEmail,
            'error'         => $error,
        ));
      }

    // CONTROLEUR DE REDIRECTION SI L'AUTHENTIFICATION N'EST PAS BONNE
    public function renderWithAccessDeniedErrorsAction($message, $route){
        $this->addFlash('danger', $message);
        return $this->redirectToRoute($route);
    }
}
