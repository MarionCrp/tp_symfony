<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use sil16\VitrineBundle\Entity\Customer;

class CustomerController extends Controller
{
    public function newAction(Request $request) {
      $customer = new Customer();
      $form = $this->createFormBuilder($customer)
         ->add('email', 'text')
         ->add('firstname', 'text')
         ->add('lastname', 'text')
         ->add('password', 'password')
         ->add('submit', 'submit')
         ->getForm();

     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {
         $new_customer = $form->getData();
         $em = $this->getDoctrine()->getManager();
         if($this->getCustomerByEmail($new_customer->getEmail())){
           $this->addFlash('danger', "Un compte existe déjà avec cette adresse email");
           return $this->redirectToRoute('sil16_vitrine_subscription');
         } else {
          // Ajout dans la BDD
         $em->persist($new_customer);
         $em->flush();

         // Mise en session
         $session = $this->getRequest()->getSession();
         $session->set('customer', $this->getCustomerByEmail($new_customer->getEmail()));

         $this->addFlash('success', "Votre compte a bien été créé");
         return $this->redirectToRoute('sil16_vitrine_accueil');
       }
     }

    //  return $this->render('customer/new.html.twig', array(
    //      'form' => $form->createView(),
    //  ));
      return $this->render('sil16VitrineBundle:Customer:new.html.twig', array('customer' => $customer, 'form' => $form->createView()));
    }

    public function destroyCustomerSessionAction(){
        $this->getRequest()->getSession()->remove('customer');
        $this->addFlash('success', "Deconnecté avec succès");
        return $this->redirectToRoute('sil16_vitrine_accueil');
    }

    private function createSession($customer) {
      $session = $this->getRequest()->getSession();
      $customer = $session->get('customer', new Customer());
      $em = $this->getDoctrine()->getManager();
    }

    private function getCustomerByEmail($email){
      $em = $this->getDoctrine()->getManager();
      $customer = $em->getRepository('sil16VitrineBundle:Customer')->findOneByEmail($email);
      return $customer;
    }
}
