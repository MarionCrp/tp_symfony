<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function indexAction($product_category_id)
    {
      $em = $this->getDoctrine()->getManager();
      $category = $em->getRepository('sil16VitrineBundle:ProductCategory')->find($product_category_id);
      $products = $category->getProducts();

      return $this->render('sil16VitrineBundle:ProductCategory:Product/index.html.twig', array('products' => $products, 'product_category' => $category));
    }
}
