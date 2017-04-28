<?php
namespace sil16\VitrineBundle\Controller;

use sil16\VitrineBundle\Form\CustomerType;
use sil16\VitrineBundle\Entity\Customer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;

class RegistrationController extends Controller
{
    // Création d'un compte utilisateur
    public function newAction(Request $request)
    {
        $new_customer = new Customer();
        $form = $this->createForm(CustomerType::class, $new_customer);

        $form->handleRequest($request);

        // Lorsque le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On vérifie que l'email n'est pas déjà présent en base
            if($this->getCustomerByEmail($new_customer->getEmail())){
              $this->addFlash('danger', "Un compte existe déjà avec cette adresse email");

              return $this->redirectToRoute('sil16_vitrine_subscription');
            } else {

              // Encodage du mot de passe
              $password = $this->get('security.password_encoder')
                  ->encodePassword($new_customer, $new_customer->getPassword());
              $new_customer->setPassword($password);

              // Un compte administrateur n'est jamais créé via cette interface !
              $new_customer->setIsAdmin(false);

              $em = $this->getDoctrine()->getManager();
              $em->persist($new_customer);
              $em->flush();

              $this->addFlash('success', "Votre compte a bien été créé");

              return $this->redirectToRoute('sil16_vitrine_accueil');
            }
        }

        return $this->render(
            'sil16VitrineBundle:Registration:new.html.twig',
            array('form' => $form->createView())
        );
    }

    // METHODES PRIVEES

    private function getCustomerByEmail($email){
      $em = $this->getDoctrine()->getManager();
      $customer = $em->getRepository('sil16VitrineBundle:Customer')->findOneByEmail($email);
      return $customer;
    }
}
