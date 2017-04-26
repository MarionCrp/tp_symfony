<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use sil16\VitrineBundle\Entity\Customer;

class SessionController extends Controller
{
    public function newAction(Request $request){
      $customer = new Customer();
      $form = $this->createFormBuilder($customer)
         ->add('email', 'text')
         ->add('password', 'password')
         ->add('submit', 'submit')
         ->getForm();

     $form->handleRequest($request);
     if ($form->isSubmitted()) {
         $logging_in_customer = $form->getData();
         $em = $this->getDoctrine()->getManager();
         $customer = $this->getCustomerByEmail($logging_in_customer->getEmail());

         if($customer){
            // On compare les mots de passe.
            if($customer->getPassword() == $logging_in_customer->getPassword()){
              // Mise en session
              $this->createSession($customer);
              $this->addFlash('success', "Connecté avec succès");
              return $this->redirectToRoute('sil16_vitrine_accueil');
            }
         }
         $this->addFlash('danger', "L'email ou le mot de passe est incorrect");
     }
      return $this->render('sil16VitrineBundle:Customer:log_in.html.twig', array('customer' => $customer, 'form' => $form->createView()));
    }

    public function destroyCustomerSessionAction(){
        $this->getRequest()->getSession()->remove('customer_id');
        $this->addFlash('success', "Deconnecté avec succès");
        return $this->redirectToRoute('sil16_vitrine_accueil');
    }

    private function createSession($customer) {
      $session = $this->getRequest()->getSession();
      $session->set('customer_id', $customer->getId());
    }

    private function getCustomerByEmail($email){
      $em = $this->getDoctrine()->getManager();
      $customer = $em->getRepository('sil16VitrineBundle:Customer')->findOneByEmail($email);
      return $customer;
    }
}
