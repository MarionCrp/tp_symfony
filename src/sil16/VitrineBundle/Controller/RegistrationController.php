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
    /**
     * @Route("/register", name="customer_registration")
     */
    public function newAction(Request $request)
    {
        // 1) build the form
        $new_customer = new Customer();
        $form = $this->createForm(CustomerType::class, $new_customer);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Verify if data with the same email exists in database
            if($this->getCustomerByEmail($new_customer->getEmail())){
              $this->addFlash('danger', "Un compte existe déjà avec cette adresse email");

              return $this->redirectToRoute('sil16_vitrine_subscription');
            } else {
              // 3) Encode the password (you could also do this via Doctrine listener)
              $password = $this->get('security.password_encoder')
                  ->encodePassword($new_customer, $new_customer->getPassword());
              $new_customer->setPassword($password);

              // 4) save the Customer!
              $em = $this->getDoctrine()->getManager();
              $em->persist($new_customer);
              $em->flush();

              // Mise en session
              $this->createSession($this->getCustomerByEmail($new_customer->getEmail()));
              $this->addFlash('success', "Votre compte a bien été créé");

              return $this->redirectToRoute('sil16_vitrine_accueil');
            }
        }

        return $this->render(
            'sil16VitrineBundle:Registration:new.html.twig',
            array('form' => $form->createView())
        );
    }

    private function getCustomerByEmail($email){
      $em = $this->getDoctrine()->getManager();
      $customer = $em->getRepository('sil16VitrineBundle:Customer')->findOneByEmail($email);
      return $customer;
    }

    private function createSession($customer) {
      $session = $this->getRequest()->getSession();
      $session->set('customer_id', $customer->getId());
    }
}
