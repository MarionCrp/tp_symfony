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
      if (!$this->get('security.authorization_checker')->isGranted('ROLE_CUSTOMER')) {
        $message = 'Vous devez être connecté pour accéder à cette page';
        return $this->redirectToRoute('render_with_access_denied_errors', array('message' => $message, 'route' => 'login'));
      }

      $current_customer = $this->getUser();
      $commandes = [];
      if($current_customer){
        $em = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository('sil16VitrineBundle:Commande')->findByUserOrderedByCreatedAt($current_customer->getId(), "DESC");
      }
      return $this->render('sil16VitrineBundle:Commande:index.html.twig', array('commandes' => $commandes));
    }

    public function createAction() {
      if (!$this->get('security.authorization_checker')->isGranted('ROLE_CUSTOMER')) {
        $message = 'Vous devez être connecté pour accéder à cette page';
        return $this->redirectToRoute('render_with_access_denied_errors', array('message' => $message, 'route' => 'login'));
      }

      $session = $this->getRequest()->getSession();
      $basket = $session->get('basket', new Basket());

      // Ajout d'unproduct dans une ligne de commande qu'on affecte à une Order
      $em = $this->getDoctrine()->getManager();
      $current_customer = $this->getUser();
        if(!empty($basket->getContent())){
            $new_commande = new Commande();
            $new_commande->setCustomer($current_customer);
            $new_commande->setState('pending');
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
                    // On met à jour les stocks lorsque la commande est effetuée
                    $product->setStock($stock - $quantity);
                    $em->persist($product);
                }
                // On supprime chaque produit du panier
                $basket->deleteProduct($product_id);
            }
             // Ajout dans la BDD
            $em->persist($new_commande);

            // Le panier est sensé être vide si tout s'est bien passé
            $session->set('basket', $basket);
            $em->flush();

            // On va rediriger le client vers la fiche détaillée de la commande qu'il vient de passer
            $last_commande = $this->getUser()->getCommandes()->last();
            $this->addFlash('success', "Félicitations pour votre commande!");
            return $this->redirectToRoute('sil16_vitrine_commande_show', array('commande_id' => $last_commande->getId()));
        } else {
            $this->addFlash('danger', "La commande a échouée : Votre panier est vide.");
            return $this->redirect($this->generateUrl('sil16_vitrine_accueil'));
        }

    }

    // Détail d'une commande
    public function showAction($commande_id){
      $commande = $this->findCommande($commande_id);
      if($commande){
        return $this->render('sil16VitrineBundle:Commande:show.html.twig', array('commande' => $commande));
      } else {
        return $this->redirect($this->generateUrl('sil16_vitrine_basket_index'));
      }
    }

    // Fonction de
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

    private function findCommande($commande_id){
      $commande_manager = $this->getDoctrine()->getManager()->getRepository('sil16VitrineBundle:Commande');
      if($commande_id){
        $commande = $commande_manager->find($commande_id);
      }
      if (!$commande) {
        $this->addFlash('danger', "La commande n'a pas été trouvée");
        return null;
      } else {
        $current_customer = $this->getUser();
        $commande->getCustomer()->getId();
        if($current_customer == $commande->getCustomer()){
          return $commande;
        } else {
          $this->addFlash('danger', "La commande n'a pas été trouvée");
          return null;
        }
      }
    }
}
