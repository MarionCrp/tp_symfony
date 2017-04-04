<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use sil16\VitrineBundle\Entity\Basket;

class OrderController extends Controller
{
    public function createAction() {
      $session = $this->getRequest()->getSession();
      $basket = $session->get('basket', new Basket());
      // Add product dans une ligne de commande qu'on affecte à une Order
      // Remove la ligne de la session basket (un article peut avoir planté mais on veut valider les autres)


      // TODO : On redirige vers l'index des Order ("Mes commandes effectuées")
      return $this->redirect($this->generateUrl('sil16_vitrine_index'));
    }

    public function addProductAction(Request $request){
        $session = $this->getRequest()->getSession();
        $params = $this->getRequest()->request->get('form');

        // PARAMS
        $product_id = $params['product_id'];
        $quantity = $params['quantity'];

        $product = $this->findProduct($product_id);

        $basket = $session->get('basket', new Basket());

        $basket->addProduct($product_id, $quantity);

        $session->set('basket', $basket);

        return $this->redirect($this->generateUrl('sil16_vitrine_basket_index'));
    }

    private function findProduct($product_id){
      $product_manager = $this->getDoctrine()->getManager()->getRepository('sil16VitrineBundle:Product');
      if($product_id){
        $product = $product_manager->find($product_id);
      }
      if (!$product) {
        throw $this->createNotFoundException("Ce produit n'existe pas");
      } else {
        return $product;
      }
    }
}
