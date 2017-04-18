<?php

namespace sil16\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use sil16\VitrineBundle\Entity\Admin;

class AdminController extends Controller
{
    public function logInAction(Request $request){
      $admin = new Admin();
      $form = $this->createFormBuilder($admin)
         ->add('email', 'text')
         ->add('password', 'password')
         ->add('submit', 'submit')
         ->getForm();

     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {
         $logging_in_admin = $form->getData();
         $em = $this->getDoctrine()->getManager();
         $admin = $this->getAdminByEmail($logging_in_admin->getEmail());
         if($admin){
            // On compare les mots de passe.
            if($admin->getPassword() == $logging_in_admin->getPassword()){
              // Mise en session
              $this->createSession($admin);
              $this->addFlash('success', "Connecté avec succès");
              return $this->redirectToRoute('admin_dashboard');
            }
         }
         $this->addFlash('danger', "L'email ou le mot de passe est incorrect");
     }
      return $this->render('sil16AdminBundle:Admin:log_in.html.twig', array('admin' => $admin, 'form' => $form->createView()));
    }

    public function destroyAdminSessionAction(){
        $this->getRequest()->getSession()->remove('admin_id');
        $this->addFlash('success', "Deconnecté avec succès");
        return $this->redirectToRoute('admin_dashboard');
    }

    private function createSession($admin) {
      $session = $this->getRequest()->getSession();
      $session->set('admin_id', $admin->getId());
    }

    private function getAdminByEmail($email){
      $em = $this->getDoctrine()->getManager();
      $admin = $em->getRepository('sil16VitrineBundle:Admin')->findOneByEmail($email);
      return $admin;
    }
}
