<?php

namespace sil16\VitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Order
 */
class Order
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \sil16\VitrineBundle\Entity\Customer
     */
    private $customer;


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
     * Set customer
     *
     * @param \sil16\VitrineBundle\Entity\Customer $customer
     * @return Order
     */
    public function setCustomer(\sil16\VitrineBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \sil16\VitrineBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $order_lines;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->order_lines = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add order_lines
     *
     * @param \sil16\VitrineBundle\Entity\OrderLine $orderLines
     * @return Order
     */
    public function addOrderLine(\sil16\VitrineBundle\Entity\OrderLine $orderLines)
    {
        $this->order_lines[] = $orderLines;

        return $this;
    }

    /**
     * Remove order_lines
     *
     * @param \sil16\VitrineBundle\Entity\OrderLine $orderLines
     */
    public function removeOrderLine(\sil16\VitrineBundle\Entity\OrderLine $orderLines)
    {
        $this->order_lines->removeElement($orderLines);
    }

    /**
     * Get order_lines
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderLines()
    {
        return $this->order_lines;
    }
}
