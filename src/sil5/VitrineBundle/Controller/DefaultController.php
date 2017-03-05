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
        $lampe_1 =
        return $this->render('sil5VitrineBundle:Default:catalogue.html.twig');
    }
}

class Lamp {
  private $reference
  private $name;
  private $picture;
  private $description;
  private $price;
  // private $couleurs[];
  // private $compositions[];
  // private $consommation;
  // private $height;
  // private $diameter;


}
