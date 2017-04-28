<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use sil16\VitrineBundle\Entity\Basket;

class BasketController extends Controller
{
    public function indexAction() {
        return $this->getContentAndRedirect('index');
    }

    // Action relative au panier incluse dans le layout
    public function getContentAction(){
      return $this->getContentAndRedirect('content');
    }

    public function addProductAction(Request $request){
        // SESSION
        $session = $this->getRequest()->getSession();

        // PARAMETRES : ID + QUANTITE
        $params = $this->getRequest()->request->get('form');
        $product_id = (int)$params['product_id'];
        $quantity = $params['quantity'];

        $product = $this->findProduct($product_id);

        $basket = $session->get('basket', new Basket());

        // On vérifie si l'article est déjà présent dans le panier, si oui on récupère sa quantité, sinon on l'initialise à 0
        $basket_product_quantity = array_key_exists($product_id, $basket->getContent()) ? $basket->getContent()[$product_id] : 0;

        // On vérifie que l'article existe en base, et on vérifie l'état des stocks par rapport à la quantité ajoutée au panier
        if($product && ($product->getStock() >= $quantity + (int) $basket_product_quantity)){
          // AJOUT DANS LE PANIER
          $basket->addProduct($product_id, $quantity);
          $session->set('basket', $basket);
          $this->addFlash('success', "Le produit a été ajouté avec succès !");
          return $this->redirect($this->generateUrl('sil16_vitrine_basket_index'));
        } else {
          // En cas d'erreur de l'ajout du produit on notifie l'utilisateur
          if(!$product){
            $this->addFlash('danger', "Le produit ajouté n'existe pas");
          } else {
            $this->addFlash('danger', "Le stock est insuffisant.");
          }
          return $this->redirect($this->generateUrl('sil16_vitrine_catalogue'));
        }
    }

    public function deleteProductAction($product_id){
        $session = $this->getRequest()->getSession();
        $product = $this->findProduct($product_id);

        if($product){
          # Récupère un panier déjà présent en session OU en créé un.
          $basket = $session->get('basket', new Basket());
          $basket->deleteProduct($product_id);
          $session->set('basket', $basket);

          $this->addFlash('success', "Le produit a bien été supprimé!");
          return $this->redirect($this->generateUrl('sil16_vitrine_basket_index'));
        } else {
          $this->addFlash('danger', "Erreur lors de la suppression du produit");
          return $this->redirect($this->generateUrl('sil16_vitrine_basket_index'));
        }
    }

    public function clearAction(){
        $session = $this->getRequest()->getSession();
        $basket = $session->get('basket', new Basket());
        $basket->clear();
        $session->set('basket', $basket);

        $this->addFlash('success', "Votre panier a été vidé");
        return $this->redirect($this->generateUrl('sil16_vitrine_accueil'));
    }

    // PRIVATE FUNCTION

    private function getContentAndRedirect($action){
      // PRODUCT MANAGER
      $product_manager = $this->getDoctrine()->getManager()->getRepository('sil16VitrineBundle:Product');

      // SESSION
      $session = $this->getRequest()->getSession();

      // BASKET
      $basket = $session->get('basket', new Basket());
      $products = [];
      $total_amount = 0; // Initialisation du prix du panier.
      // On récupère chaque produit enregistré en session par son id, et sa quantité.
      if($basket->getContent()){
        foreach($basket->getContent() as $product_id => $qty){
          $product = $this->findProduct($product_id);
          if($product){
            $products[] = array(
              'product' => $product,
              'qty' => $qty
            );
          }
          $total_amount += $product->getPrice() * $qty; // Le prix est calculé en fonction du prix de l'article (en direct)
        }
      }
      return $this->render('sil16VitrineBundle:Basket:'.$action.'.html.twig', array('products' => $products, 'total_amount' => $total_amount));
    }

    private function findProduct($product_id){
      $product_manager = $this->getDoctrine()->getManager()->getRepository('sil16VitrineBundle:Product');
      if($product_id){
        $product = $product_manager->find($product_id);
      }
      if (!$product) {
        // Si le produit n'a pas été trouvé on supprime la ligne associée à cet article inconnu
        $session = $this->getRequest()->getSession();
        $basket = $session->get('basket', new Basket());
        $basket->deleteProduct($product_id);
        $session->set('basket', $basket);
        return null;
      } else {
        return $product;
      }
    }

}
