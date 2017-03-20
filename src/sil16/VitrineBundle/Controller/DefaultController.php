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
      $categories = $em->getRepository('sil16VitrineBundle:Category')->findAll();
      return $this->render('sil16VitrineBundle:Default:catalogue.html.twig', array('categories' => $categories));
    }

    public function articlesParCategorieAction($category_id)
    {
      $em = $this->getDoctrine()->getManager();
      $category = $em->getRepository('sil16VitrineBundle:Category')->find($category_id);
      $products = $category->getProducts();

      return $this->render('sil16VitrineBundle:Default:articlesParCategorie.html.twig', array('products' => $products, 'category' => $category));
    }
}
