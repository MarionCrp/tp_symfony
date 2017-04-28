<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use sil16\VitrineBundle\Entity\Product;

class ProductController extends Controller
{
    public function indexAction($product_category_id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('sil16VitrineBundle:ProductCategory')->find($product_category_id);
        if(!$category){
          $this->addFlash('danger', "La catégorie demandée n'existe pas !");
          return $this->redirect($this->generateUrl('sil16_vitrine_accueil'));
        } else {
          // On ne récupère que les produits actifs
          $products = $em->getRepository('sil16VitrineBundle:Product')->findByActiveWithCategory($product_category_id);
          //Initialisation des formulaires d'ajout au panier
          $data = array();
          $form_views = [];

          foreach($products as $product){
            $form = $this->createFormBuilder($data, array(
                'action' => $this->generateUrl('sil16_vitrine_basket_add_product')
            ))
            ->add('product_id', 'hidden')
            ->add('quantity', 'integer', array("label" => "Quantité", "data" => 1))
            ->add('submit', 'submit')
            ->getForm();
            $form_views[$product->getId()] = $form->createView();
          }

          return $this->render('sil16VitrineBundle:ProductCategory:Product/index.html.twig',
                               array('products' => $products,
                                     'product_category' => $category,
                                     'forms' => $form_views
                                   )
                                 );
        }
      }

      // Renvoie les produits actifs les plus vendus
      public function bestSellAction(){
        $em = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository('sil16VitrineBundle:Commande')->findAll();
        if($commandes){
          $products = $em->getRepository('sil16VitrineBundle:Product')->findBestSells();
          return $this->render('sil16VitrineBundle:ProductCategory:Product/best_sell.html.twig', array('products' => $products));
        }
      }
}
