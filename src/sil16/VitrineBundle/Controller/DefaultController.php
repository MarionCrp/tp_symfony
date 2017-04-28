<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// CONTROLEUR DES PAGES STATICS
class DefaultController extends Controller
{
    // PAGE d'ACCUEIL
    public function indexAction($name)
    {
      $user = $this->getUser(); // C’est un objet de la classe Client !

        $current_customer = $this->getUser();
        if($current_customer){
          $name = $current_customer->getFirstname();
        }
        return $this->render('sil16VitrineBundle:Default:index.html.twig', array('name' => $name));
    }

    // PAGE DE MENTIONS LEGALES
    public function mentionsAction()
    {
        return $this->render('sil16VitrineBundle:Default:mentions.html.twig');
    }
}
