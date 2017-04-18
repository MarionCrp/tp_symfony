<?php

namespace sil16\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
      $admin = $this->findCurrentAdmin();
      if($admin){
        return $this->render('sil16AdminBundle:Default:index.html.twig', array());
      } else {
        return $this->redirectToRoute('admin_login');
      }
    }

    private function findCurrentAdmin(){
      $session = $this->getRequest()->getSession();
      $admin_id = (int) $session->get('admin_id');
      $admin_manager = $this->getDoctrine()->getManager()->getRepository('sil16VitrineBundle:Admin');
      $admin = $admin_manager->find($admin_id);
      return $admin;
    }
}
