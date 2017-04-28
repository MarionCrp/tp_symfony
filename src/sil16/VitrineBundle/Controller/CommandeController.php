<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use sil16\VitrineBundle\Entity\Basket;
use sil16\VitrineBundle\Entity\Product;
use sil16\VitrineBundle\Entity\Commande;
use sil16\VitrineBundle\Entity\OrderLine;

class CommandeController extends Controller
{
    public function indexAction(){
      // Vérification qu'un client est authentifié.
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
      // Vérification qu'un client est authentifié.
      if (!$this->get('security.authorization_checker')->isGranted('ROLE_CUSTOMER')) {
        $message = 'Vous devez être connecté pour accéder à cette page';
        return $this->redirectToRoute('render_with_access_denied_errors', array('message' => $message, 'route' => 'login'));
      }

      // SESSION & PANIER
      $session = $this->getRequest()->getSession();
      $basket = $session->get('basket', new Basket());

      $em = $this->getDoctrine()->getManager();
      $current_customer = $this->getUser();
      if(empty($basket->getContent())){
        $this->addFlash('danger', "La commande a échouée: votre panier est vide");
        return $this->redirect($this->generateUrl('sil16_vitrine_accueil'));
      } else {
          $new_commande = new Commande();
          $new_commande->setCustomer($current_customer);
          $new_commande->setState('pending');

          // Vérificateurs et notifieurs d'erreurs
          $order_lines_count = 0;
          $error_with_a_product = false;

          // Création d'une ligne de commande pour chaque article (avec sa quantité)
          foreach($basket->getContent() as $product_id => $quantity){
              $product = $this->findProduct($product_id);
              // On vérifie que le produit existe et que le stock suffise
              if($product && $product->getActive() === true && $product->getStock() >= $quantity){
                  $order_line = new OrderLine;
                  $order_line->setUnitPrice($product->getPrice());
                  $order_line->setQuantity($quantity);
                  $order_line->setProduct($product);
                  $order_line->setCommande($new_commande);
                  $em->persist($order_line);
                  // Compteur qui nous permet de savoir si la commande n'est pas vide
                  $order_lines_count += 1;

                  $stock = $product->getStock();
                  // On met à jour les stocks lorsque la commande est effetuée
                  $product->setStock($stock - $quantity);
                  $em->persist($product);

              } else { // Le produit n'a pas été trouvé en base
                $error_with_a_product = true;
              }
              // On supprime chaque produit du panier
              $basket->deleteProduct($product_id);
            }

             // Ajout dans la BDD seulement si au moins une ligne de produit à pu être ajoutée
            if(count($order_lines_count > 0)){
                  $em->persist($new_commande);
                  // Le panier est sensé être vide si tout s'est bien passé
                  $session->set('basket', $basket);
                  $em->flush();

                  // La commande qui vient d'être effectuée et dont on va affiché le détail à la fin de cette action
                  $last_commande = $this->getUser()->getCommandes()->last();
                  if($error_with_a_product){
                        $this->addFlash('danger', "Attention, des produits n'ont pas pu être ajoutés à votre commande!");
                  } else {
                        $this->addFlash('success', "Félicitations pour votre commande!");
                  }
                  // On va rediriger le client vers la fiche détaillée de la commande qu'il vient de passer
                  return $this->redirectToRoute('sil16_vitrine_commande_show', array('commande_id' => $last_commande->getId()));
              } else {
                  $this->addFlash('danger', "La commande a échouée.");
                  return $this->redirect($this->generateUrl('sil16_vitrine_accueil'));
              }
            }
        }

    // Détail d'une commande
    public function showAction($commande_id){
      // Vérification qu'un client est authentifié.
      if (!$this->get('security.authorization_checker')->isGranted('ROLE_CUSTOMER')) {
        $message = 'Vous devez être connecté pour accéder à cette page';
        return $this->redirectToRoute('render_with_access_denied_errors', array('message' => $message, 'route' => 'login'));
      }

      $commande = $this->findCommande($commande_id);
      if($commande){
        return $this->render('sil16VitrineBundle:Commande:show.html.twig', array('commande' => $commande));
      } else {
        return $this->redirect($this->generateUrl('sil16_vitrine_basket_index'));
      }
    }

    // METHODES PRIVEES

    // Récupérer un produit dans la base de donnée
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

    // Récupérer une commande dans la base de données
    private function findCommande($commande_id){
      $commande_manager = $this->getDoctrine()->getManager()->getRepository('sil16VitrineBundle:Commande');
      // on récupère la commande dans la base
      if($commande_id){
        $commande = $commande_manager->find($commande_id);
      }
      if (!$commande) {
        $this->addFlash('danger', "La commande n'a pas été trouvée");
        return null;
      } else {
        $current_customer = $this->getUser();
        $commande->getCustomer()->getId();
        // On vérifie que la commande trouvée appartient bien au client authentifié.
        if($current_customer == $commande->getCustomer()){
          return $commande;
        } else {
          $this->addFlash('danger', "La commande n'a pas été trouvée");
          return null;
        }
      }
    }
}
