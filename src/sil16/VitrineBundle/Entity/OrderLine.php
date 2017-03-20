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
    private $price;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $products;

    /**
     * @var \sil16\VitrineBundle\Entity\Order
     */
    private $order;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set price
     *
     * @param string $price
     * @return OrderLine
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Add products
     *
     * @param \sil16\VitrineBundle\Entity\Product $products
     * @return OrderLine
     */
    public function addProduct(\sil16\VitrineBundle\Entity\Product $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \sil16\VitrineBundle\Entity\Product $products
     */
    public function removeProduct(\sil16\VitrineBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set order
     *
     * @param \sil16\VitrineBundle\Entity\Order $order
     * @return OrderLine
     */
    public function setOrder(\sil16\VitrineBundle\Entity\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \sil16\VitrineBundle\Entity\Order 
     */
    public function getOrder()
    {
        return $this->order;
    }
    /**
     * @var string
     */
    private $unit_price;

    /**
     * @var \sil16\VitrineBundle\Entity\Product
     */
    private $product;


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
}
