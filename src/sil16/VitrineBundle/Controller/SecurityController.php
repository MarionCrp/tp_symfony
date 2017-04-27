<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use sil16\VitrineBundle\Entity\Customer;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
  public function logInAction(Request $request) {

      if($this->getUser()){
        $this->addFlash('success', "Vous êtes déjà connecté");
        return $this->redirect($this->generateUrl('sil16_vitrine_accueil'));
      }
      $authenticationUtils = $this->get('security.authentication_utils');

      // get the login error if there is one
      $error = $authenticationUtils->getLastAuthenticationError();

      // last username entered by the user
      $lastEmail = $authenticationUtils->getLastUsername();

      return $this->render('sil16VitrineBundle:Security:login.html.twig', array(
          'last_email' => $lastEmail,
          'error'         => $error,
      ));
    }
}
