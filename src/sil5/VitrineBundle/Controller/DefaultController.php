<?php

namespace sil5\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('sil5VitrineBundle:Default:index.html.twig', array('name' => $name));
    }

    public function mentionsAction()
    {
        return $this->render('sil5VitrineBundle:Default:mentions.html.twig');
    }

    public function catalogueAction()
    {
      $lamps = array(
        new Lamp("Kanur",
                 "img_01_2.jpg",
                 "Pour un dépaysement garanti, invitez les lumières chaudes de l'Orient dans votre intérieur avec cette belle lampe à poser.",
                 59.90),
        new Lamp("Mahara",
                 "img_02_2.jpg",
                 "Forme originale et look tendance pour cette lampe avec abat-jour tout en noir et au coloris argenté.",
                 99.90),
        new Lamp("Sewal",
                 "img_03_2.jpg",
                 "Une très belle lampe à poser qui trouve son originalité dans ses 3 points lumineux et abats-jour de coloris différents, ainsi qu'avec son pied en acier brossé !",
                 49.99),
        new Lamp("Mahara",
                 "img_04_2.jpg",
                 "Forme originale et look tendance pour cette lampe avec abat-jour tout en chrome coloris argenté.",
                 99.90),
        new Lamp("Mulshi",
                 "img_05_2.jpg",
                 "Forme originale et look tendance pour cette lampe avec abat-jour tout en noir et au coloris chromé.",
                 39.99)
               );

        return $this->render('sil5VitrineBundle:Default:catalogue.html.twig', array('lamps' => $lamps));
    }
}

class Lamp {
  private $name;
  private $picture;
  private $description;
  private $price;
  // private $couleurs[];
  // private $compositions[];
  // private $consommation;
  // private $height;
  // private $diameter;

  public function __construct($name, $picture, $description, $price){
    $this->setName($name);
    $this->setPicture($picture);
    $this->setDescription($description);
    $this->setPrice($price);
  }

  public function setName($name){
    $this->name = $name;
  }


  public function setPicture($picture){
    $this->picture = $picture;
  }

  public function setDescription($description){
    $this->description = $description;
  }

  public function setPrice($price){
    $this->price = $price;
  }

  public function name(){
    return $this->name;
  }
  public function picture(){
    return $this->picture;
  }
  public function description(){
    return $this->description;
  }
  public function price(){
    return $this->price;
  }

  public function price_to_s(){
    return number_format($this->price, 2, '€', '');
  }
}
