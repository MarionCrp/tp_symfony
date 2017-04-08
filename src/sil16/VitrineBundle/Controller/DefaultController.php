<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $em = $this->getDoctrine()->getManager();
        $order_manager = $this->getDoctrine()->getManager()->getRepository('sil16VitrineBundle:Commande');
        $order = $order_manager->find(9);
        return $this->render('sil16VitrineBundle:Default:index.html.twig', array('name' => $name, 'order' => $order));
    }

    public function mentionsAction()
    {
        return $this->render('sil16VitrineBundle:Default:mentions.html.twig');
    }
}
