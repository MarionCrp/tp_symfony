<?php

namespace sil16\VitrineBundle\Entity;

/**
 * Basket
 */

class Basket {

  private $content;
  //Tableau - contenu[i] = quantite d'article d’id=i dans le panier)

  public function __construct() {
     $content = [];
  }

  public function getContent() {
     return $this->content;
  }

  public function addProduct ($product_id, $qty = 1) {
    if(array_key_exists($product_id, $this->getContent())){
      $this->content[$product_id] += $qty;
    } else {
      $this->content[$product_id] = $qty;
    }
  }

  public function deleteProduct($productId) {
  // supprimer l'article $articleId du contenu
  }

  public function clear() {
  // vide le contenu
  }
}
