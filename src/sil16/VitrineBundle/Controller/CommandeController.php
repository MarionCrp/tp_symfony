<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use sil16\VitrineBundle\Entity\Basket;
use sil16\VitrineBundle\Entity\Commande;
use sil16\VitrineBundle\Entity\OrderLine;

class CommandeController extends Controller
{
    public function indexAction(){
      $current_customer = $this->findCurrentCustomer();
      $commandes = [];
      if($current_customer){
        $commandes = $current_customer->getCommandes();
      }
      return $this->render('sil16VitrineBundle:Commande:index.html.twig', array('commandes' => $commandes));
    }

    public function createAction() {
      $session = $this->getRequest()->getSession();
      $basket = $session->get('basket', new Basket());
      // Add product dans une ligne de commande qu'on affecte à une Order
      $em = $this->getDoctrine()->getManager();
      $current_customer = $this->findCurrentCustomer();
      if(!$current_customer){
        $this->addFlash('danger', "Vous devez être connecté pour commander");
        return $this->redirect($this->generateUrl('sil16_vitrine_login'));
      } else {
        if(!empty($basket->getContent())){
          $new_commande = new Commande();
          $new_commande->setCustomer($current_customer);
          foreach($basket->getContent() as $product_id => $quantity){
            $product = $this->findProduct($product_id);
            // On vérifie que le produit existe et que le stock suffise
            if($product && $product->getStock() >= $quantity){
              $order_line = new OrderLine;
              $order_line->setUnitPrice($product->getPrice());
              $order_line->setQuantity($quantity);
              $order_line->setProduct($product);
              $order_line->setCommande($new_commande);
              $em->persist($order_line);

              $stock = $product->getStock();
              $product->setStock($stock - $quantity);
              $em->persist($product);
            }
            $basket->deleteProduct($product_id);
          }
           // Ajout dans la BDD
          $em->persist($new_commande);

          // Le panier est sensé être vide si tout s'est bien passé
          $session->set('basket', $basket);
          $em->flush();
          $this->addFlash('success', "Félicitation pour votre commande!");
          return $this->redirect($this->generateUrl('sil16_vitrine_commande_index'));
        } else {
          $this->addFlash('danger', "La commande a échouée : Votre panier est vide.");
          return $this->redirect($this->generateUrl('sil16_vitrine_accueil'));
        }
      }
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

    public function validation($product_id){
      
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

    private function findCurrentCustomer(){
      $session = $this->getRequest()->getSession();
      $customer_id = (int) $session->get('customer_id');
      $customer_manager = $this->getDoctrine()->getManager()->getRepository('sil16VitrineBundle:Customer');
      $customer = $customer_manager->find($customer_id);
        return $customer;
    }
}
