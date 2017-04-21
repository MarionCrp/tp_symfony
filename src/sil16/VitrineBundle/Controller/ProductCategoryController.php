<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductCategoryController extends Controller
{
    public function indexAction()
    {
      $em = $this->getDoctrine()->getManager();
      $product_categories = $em->getRepository('sil16VitrineBundle:ProductCategory')->findAll();
      return $this->render('sil16VitrineBundle:ProductCategory:index.html.twig', array('product_categories' => $product_categories));
    }
}
