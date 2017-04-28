<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
      $user = $this->getUser(); // C’est un objet de la classe Client !

        $current_customer = $this->getUser();
        if($current_customer){
          $name = $current_customer->getFirstname();
        }
        return $this->render('sil16VitrineBundle:Default:index.html.twig', array('name' => $name));
    }

    public function mentionsAction()
    {
        return $this->render('sil16VitrineBundle:Default:mentions.html.twig');
    }

    public function renderWithAccessDeniedErrorsAction($message, $route){
        $this->addFlash('danger', $message);
        return $this->redirectToRoute($route);
    }
}
