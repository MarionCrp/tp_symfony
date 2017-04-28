<?php

namespace sil16\VitrineBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CommandeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommandeRepository extends EntityRepository
{
    //Les Commandes sont ordonnées par ordre décroissant de date de commande (on affiche d'abord les plus récentes)

    // Commandes relatives à un client
    public function findByUserOrderedByCreatedAt($customer_id, $order="DESC") {
        $qb = $this->createQueryBuilder('c');
        return $qb->join('c.customer', 'cust', 'WITH', 'cust.id = :customer_id')
                  ->setParameter('customer_id', $customer_id)
                  ->orderBy('c.created_at', $order)
                  ->getQuery()
                  ->getResult();
      }

      // Toutes les commandes
      public function findAllOrderedByCreatedAt($order="DESC") {
          $qb = $this->createQueryBuilder('c');
          return $qb->orderBy('c.created_at', $order)
                    ->getQuery()
                    ->getResult();
        }
}
