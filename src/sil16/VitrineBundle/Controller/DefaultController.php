<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('sil16VitrineBundle:Default:index.html.twig', array('name' => $name));
    }

    public function mentionsAction()
    {
        return $this->render('sil16VitrineBundle:Default:mentions.html.twig');
    }

    public function catalogueAction()
    {
      $em = $this->getDoctrine()->getManager();
      $product_categories = $em->getRepository('sil16VitrineBundle:ProductCategory')->findAll();
      return $this->render('sil16VitrineBundle:Default:catalogue.html.twig', array('product_categories' => $product_categories));
    }

    public function productsByCategoryAction($product_category_id)
    {
      $em = $this->getDoctrine()->getManager();
      $category = $em->getRepository('sil16VitrineBundle:ProductCategory')->find($product_category_id);
      $products = $category->getProducts();

      return $this->render('sil16VitrineBundle:Default:products_by_category.html.twig', array('products' => $products, 'product_category' => $category));
    }
}
