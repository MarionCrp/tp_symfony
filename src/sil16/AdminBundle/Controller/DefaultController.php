<?php

namespace sil16\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
      die();
      // if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
      //   $this->addFlash('success', "Veuillez vous connecter avec votre compte administrateur pour accéder au back-office");
      //   return $this->redirectToRoute('login');
      // } else {
      //   return $this->render('sil16AdminBundle:Default:index.html.twig', array());
      // }
    }
}
