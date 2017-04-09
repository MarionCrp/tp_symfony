<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use sil16\VitrineBundle\Entity\Basket;

class BasketController extends Controller
{
    public function indexAction() {
        $product_manager = $this->getDoctrine()->getManager()->getRepository('sil16VitrineBundle:Product');
        $session = $this->getRequest()->getSession();
        $basket = $session->get('basket', new Basket());
        $products = [];
        if($basket->getContent()){
          $data = array();
          $formBuilder = $this->createFormBuilder($data, array(
              'action' => $this->generateUrl('sil16_vitrine_basket_index')
          ));
          foreach($basket->getContent() as $product_id => $qty){
            $product = $this->findProduct($product_id);
            if($product){
              $products[] = array(
                'product' => $product,
                'qty' => $qty
              );
              $formBuilder->add('quantity', 'number', array("label" => "Quantité", "data" => $basket->getContent()[$product_id]));
            }
          }
          $formBuilder->add('submit', 'submit');
          $form = $formBuilder->getForm();
        } else {
          return $this->render('sil16VitrineBundle:Basket:index.html.twig', array('products' => $products, 'form' => null));
        }

        return $this->render('sil16VitrineBundle:Basket:index.html.twig', array('products' => $products, 'form' => $form->createView()));
    }

    public function addProductAction(Request $request){
        $session = $this->getRequest()->getSession();
        $params = $this->getRequest()->request->get('form');

        // PARAMS
        $product_id = (int)$params['product_id'];
        $quantity = $params['quantity'];

        $product = $this->findProduct($product_id);

        $basket = $session->get('basket', new Basket());
        $basket_product_quantity = array_key_exists($product_id, $basket->getContent()) ? $basket->getContent()[$product_id] : 0;
        if($product && ($product->getStock() >= $quantity + (int) $basket_product_quantity)){
          $basket->addProduct($product_id, $quantity);
          $session->set('basket', $basket);
          $this->addFlash('success', "Le produit a été ajouté avec succès !");
          return $this->redirect($this->generateUrl('sil16_vitrine_basket_index'));
        } else {
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
        # Récupère un panier déjà présent en session OU en créé un.
        $basket = $session->get('basket', new Basket());
        $basket->clear();
        $session->set('basket', $basket);
        $this->addFlash('success', "Votre panier a été vidé");
        return $this->redirect($this->generateUrl('sil16_vitrine_accueil'));
    }

    private function findProduct($product_id){
      $product_manager = $this->getDoctrine()->getManager()->getRepository('sil16VitrineBundle:Product');
      if($product_id){
        $product = $product_manager->find($product_id);
      }
      if (!$product) {
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
