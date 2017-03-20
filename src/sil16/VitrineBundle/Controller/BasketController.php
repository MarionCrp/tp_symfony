<?php

namespace sil16\VitrineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BasketController extends Controller
{
    public function indexAction() {
        return $this->render('sil16VitrineBundle:Basket:index.html.twig');
    }
}
