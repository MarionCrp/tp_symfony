<?php

namespace sil16\VitrineBundle\Entity;

/**
 * Basket
 */

class Basket {

  private $content = [];
  //Tableau - contenu[i] = quantite d'article d’id=i dans le panier)

  public function __construct() {
     $content = [];
  }

  public function getContent() {
     return $this->content;
  }
  public function setContent($content) {
     $this->content = $content;
  }

  public function addProduct ($product_id, $qty = 1) {
    if(array_key_exists($product_id, $this->getContent())){
      $this->content[$product_id] += $qty;
    } else {
      $this->content[$product_id] = $qty;
    }
  }

  public function deleteProduct($productId) {
    if(array_key_exists((int) $productId, $this->getContent())){
      unset($this->content[$productId]);
    }
  }

  public function clear() {
    $this->setContent([]);
  }
}
