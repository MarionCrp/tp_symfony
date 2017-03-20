<?php

namespace sil16\VitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PictureCategory
 */
class PictureCategory
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $products;

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
     * Set name
     *
     * @param string $name
     * @return PictureCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add products
     *
     * @param \sil16\VitrineBundle\Entity\Picture $products
     * @return PictureCategory
     */
    public function addProduct(\sil16\VitrineBundle\Entity\Picture $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \sil16\VitrineBundle\Entity\Picture $products
     */
    public function removeProduct(\sil16\VitrineBundle\Entity\Picture $products)
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $pictures;


    /**
     * Add pictures
     *
     * @param \sil16\VitrineBundle\Entity\Picture $pictures
     * @return PictureCategory
     */
    public function addPicture(\sil16\VitrineBundle\Entity\Picture $pictures)
    {
        $this->pictures[] = $pictures;

        return $this;
    }

    /**
     * Remove pictures
     *
     * @param \sil16\VitrineBundle\Entity\Picture $pictures
     */
    public function removePicture(\sil16\VitrineBundle\Entity\Picture $pictures)
    {
        $this->pictures->removeElement($pictures);
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPictures()
    {
        return $this->pictures;
    }
}
