<?php

namespace sil16\VitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 */
class Product
{

  const LIMITED_STOCK = 10;
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $description;


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
     * @return Product
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
     * Set price
     *
     * @param string $price
     * @return Product
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
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @var string
     */
    private $manyToOne;

    /**
     * @var string
     */
    private $oneToMany;


    /**
     * Set manyToOne
     *
     * @param string $manyToOne
     * @return Product
     */
    public function setManyToOne($manyToOne)
    {
        $this->manyToOne = $manyToOne;

        return $this;
    }

    /**
     * Get manyToOne
     *
     * @return string
     */
    public function getManyToOne()
    {
        return $this->manyToOne;
    }

    /**
     * Set oneToMany
     *
     * @param string $oneToMany
     * @return Product
     */
    public function setOneToMany($oneToMany)
    {
        $this->oneToMany = $oneToMany;

        return $this;
    }

    /**
     * Get oneToMany
     *
     * @return string
     */
    public function getOneToMany()
    {
        return $this->oneToMany;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $pictures;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pictures = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add pictures
     *
     * @param \sil16\VitrineBundle\Entity\Picture $pictures
     * @return Product
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

    public function price_to_s(){
      return number_format($this->price, 2, '€', '');
    }
    /**
     * @var integer
     */
    private $stock;


    /**
     * Set stock
     *
     * @param integer $stock
     * @return Product
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer
     */
    public function getStock()
    {
        return $this->stock;
    }
    /**
     * @var \sil16\VitrineBundle\Entity\ProductCategory
     */
    private $product_category;


    /**
     * Set product_category
     *
     * @param \sil16\VitrineBundle\Entity\ProductCategory $productCategory
     * @return Product
     */
    public function setProductCategory(\sil16\VitrineBundle\Entity\ProductCategory $productCategory = null)
    {
        $this->product_category = $productCategory;

        return $this;
    }

    /**
     * Get product_category
     *
     * @return \sil16\VitrineBundle\Entity\ProductCategory
     */
    public function getProductCategory()
    {
        return $this->product_category;
    }
}
