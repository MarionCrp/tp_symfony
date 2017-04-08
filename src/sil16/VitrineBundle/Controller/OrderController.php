<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use sil16\VitrineBundle\Entity\Basket;
use sil16\VitrineBundle\Entity\Commande;
use sil16\VitrineBundle\Entity\OrderLine;

class OrderController extends Controller
{
    public function createAction() {
      $session = $this->getRequest()->getSession();
      $basket = $session->get('basket', new Basket());
      // Add product dans une ligne de commande qu'on affecte à une Order
      $em = $this->getDoctrine()->getManager();

      if(!empty($basket->getContent())){
        $new_order = new Commande();
        $new_order->setCustomer($this->findCustomer());
        foreach($basket->getContent() as $product_id => $quantity){
          $product = $this->findProduct($product_id);
          // On vérifie que le produit existe et que le stock suffise
          if($product && $product->getStock() >= $quantity){
            $order_line = new OrderLine;
            $order_line->setUnitPrice($product->getPrice());
            $order_line->setQuantity($quantity);
            $order_line->setProduct($product);
            $order_line->setCommande($new_order);
            $em->persist($order_line);

            $stock = $product->getStock();
            $product->setStock($stock - $quantity);
            $em->persist($product);
          }
          $basket->deleteProduct($product_id);
        }
         // Ajout dans la BDD
        $em->persist($new_order);


        // Le panier est sensé être vide si tout s'est bien passé
        $session->set('basket', $basket);
        $em->flush();
        $this->addFlash('success', "Félicitation pour votre commande!");
      } else {
        $this->addFlash('danger', "La commande a échouée : Votre panier est vide.");
      }

      // TODO : On redirige vers l'index des Order ("Mes commandes effectuées")
      return $this->redirect($this->generateUrl('sil16_vitrine_accueil'));
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
        throw $this->createNotFoundException("Erreur : Ce produit n'existe pas");
      } else {
        return $product;
      }
    }

    private function findCustomer(){
      $session = $this->getRequest()->getSession();
      $customer_id = (int) $session->get('customer_id');
      $customer_manager = $this->getDoctrine()->getManager()->getRepository('sil16VitrineBundle:Customer');
      $customer = $customer_manager->find($customer_id);
      if(!$customer){
        throw $this->createNotFoundException("Erreur : L'utilisateur n'existe pas");
      } else {
        return $customer;
      }
    }
}
