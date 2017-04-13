<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $current_customer = $this->findCurrentCustomer();
        if($current_customer){
          $name = $current_customer->getFirstname();
        }
        $em = $this->getDoctrine()->getManager();
        $order_manager = $this->getDoctrine()->getManager()->getRepository('sil16VitrineBundle:Commande');
        $order = $order_manager->find(9);
        return $this->render('sil16VitrineBundle:Default:index.html.twig', array('name' => $name, 'order' => $order));
    }

    public function mentionsAction()
    {
        return $this->render('sil16VitrineBundle:Default:mentions.html.twig');
    }

    private function findCurrentCustomer(){
      $session = $this->getRequest()->getSession();
      $customer_id = (int) $session->get('customer_id');
      $customer_manager = $this->getDoctrine()->getManager()->getRepository('sil16VitrineBundle:Customer');
      $customer = $customer_manager->find($customer_id);
        return $customer;
    }
}
