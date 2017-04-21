<?php

namespace sil16\AdminBundle\Controller;

use sil16\VitrineBundle\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Commande controller.
 *
 */
class CommandeController extends Controller
{
    /**
     * Lists all Commande entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository('sil16VitrineBundle:Commande')->findAllOrderedByCreatedAt("DESC");

        return $this->render('sil16AdminBundle:Commande:index.html.twig', array(
            'commandes' => $commandes,
        ));
    }

    /**
     * Creates a new commandeCategory entity.
     *
     */
    public function newAction(Request $request)
    {
        $commande = new Commande();
        $form = $this->createForm('sil16\AdminBundle\Form\CommandeType', $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush($commande);

            return $this->redirectToRoute('admin_commande_edit', array('id' => $commande->getId()));
        }

        return $this->render('sil16AdminBundle:Commande:new.html.twig', array(
            'commande' => $commande,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commande entity.
     *
     */
    public function editAction(Request $request, Commande $commande)
    {

        $editForm = $this->createForm('sil16\AdminBundle\Form\CommandeType', $commande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "la commande a été éditée avec succès");
            return $this->redirectToRoute('admin_commande_edit', array('id' => $commande->getId()));
        }

        return $this->render('sil16AdminBundle:Commande:edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
        ));
    }
}
