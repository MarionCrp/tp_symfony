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
         ->add('submit', 'submit')
         ->getForm();

     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {
         $customer = $form->getData();
         $em = $this->getDoctrine()->getManager();
         $em->persist($customer);
         $em->flush();

         return $this->redirectToRoute('sil16_vitrine_accueil');
     }

    //  return $this->render('customer/new.html.twig', array(
    //      'form' => $form->createView(),
    //  ));
      return $this->render('sil16VitrineBundle:Customer:new.html.twig', array('customer' => $customer, 'form' => $form->createView()));
    }
}
