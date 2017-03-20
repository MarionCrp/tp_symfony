<?php

namespace VotreNom\VitrineBundle\Entity;

/**
 * Basket
 */

class Panier {

  private $content;
  //Tableau - contenu[i] = quantite d'article d’id=i dans le panier)

  public function __construct() {
  // initialise le contenu
  }

  public function getContent() {
  // getter
  }

  public function addProduct ($productId, $qte = 1) {
  // ajoute l'article $articleId au contenu, en quantité $qte
  // (vérifier si l'article n'y est pas déjà)
  }

  public function deleteProduct($productId) {
  // supprimer l'article $articleId du contenu
  }

  public function clear() {
  // vide le contenu
