<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductCategoryController extends Controller
{
    public function indexAction()
    {
      $em = $this->getDoctrine()->getManager();
      $product_categories = $em->getRepository('sil16VitrineBundle:ProductCategory')->findAll();

      // On stock dans un tableau les catégories, et le nombre de produits actifs associés
      foreach($product_categories as $category){
        $results[] = array(
          'product_category' => $category,
          'active_products_count' => count($em->getRepository('sil16VitrineBundle:Product')->findByActiveWithCategory($category->getId()))
        );
        }
      return $this->render('sil16VitrineBundle:ProductCategory:index.html.twig', array('results' => $results));
    }
}
