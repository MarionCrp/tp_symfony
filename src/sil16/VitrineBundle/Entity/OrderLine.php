<?php

namespace sil16\VitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderLine
 */
class OrderLine
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $quantity;

    /**
     * @var string
     */
    private $unit_price;

    /**
     * @var \sil16\VitrineBundle\Entity\Product
     */
    private $product;

    /**
     * @var \sil16\VitrineBundle\Entity\Commande
     */
    private $commande;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return OrderLine
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set unit_price
     *
     * @param string $unitPrice
     * @return OrderLine
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unit_price = $unitPrice;

        return $this;
    }

    /**
     * Get unit_price
     *
     * @return string 
     */
    public function getUnitPrice()
    {
        return $this->unit_price;
    }

    /**
     * Set product
     *
     * @param \sil16\VitrineBundle\Entity\Product $product
     * @return OrderLine
     */
    public function setProduct(\sil16\VitrineBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \sil16\VitrineBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set commande
     *
     * @param \sil16\VitrineBundle\Entity\Commande $commande
     * @return OrderLine
     */
    public function setCommande(\sil16\VitrineBundle\Entity\Commande $commande = null)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \sil16\VitrineBundle\Entity\Commande 
     */
    public function getCommande()
    {
        return $this->commande;
    }
}
