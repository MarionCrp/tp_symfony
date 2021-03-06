<?php

namespace sil16\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use sil16\VitrineBundle\Entity\Product;
use sil16\VitrineBundle\Entity\ProductCategory;

/**
 * Product controller.
 *
 */
class ProductController extends Controller
{
    /**
     * Lists all productCategory entities.
     *
     */
    public function indexAction(Request $request)
    {
        // Vérification de l'authentification
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
          return $this->redirectToRoute('render_with_access_denied_errors');
        }

        $em = $this->getDoctrine()->getManager();

        // FILTRES par catégories ou produits actifs.
        $category_id_requested = $request->query->get('by_product_category_id');
        $active_state_requested = $request->query->get('by_active');

        // On caste la valeur en booléen si "true"/"false"
        if($active_state_requested === "false"){
          $active_state_requested = false;
        } else if($active_state_requested === "true") {
          $active_state_requested = true;
        }

        // On initialise le tableau
        $products = [];

        // Filtre par catégorie et active/inactive/tous selon le paramètre envoyé.
        if($category_id_requested){
            if($active_state_requested === "both" || $active_state_requested === null){
                $category = $em->getRepository('sil16VitrineBundle:ProductCategory')->find($category_id_requested);
                $products = $category->getProducts();
            } else {
              $products = $em->getRepository('sil16VitrineBundle:Product')->findByActiveWithCategory($category_id_requested, $active_state_requested);
            }
        } else {
            if($active_state_requested === "both" || $active_state_requested === null){
              $products = $em->getRepository('sil16VitrineBundle:Product')->findAll();
            } else {

              $products = $em->getRepository('sil16VitrineBundle:Product')->findByActive($active_state_requested);
            }
        }

        // Si pas de paramètre on affiche tout
        $product_categories = $em->getRepository('sil16VitrineBundle:ProductCategory')->findAll();

        return $this->render('sil16AdminBundle:Product:index.html.twig', array(
            'products' => $products,
            'product_categories' => $product_categories,
        ));
    }

    /**
     * Creates a new productCategory entity.
     *
     */
    public function newAction(Request $request)
    {
        // Vérification de l'authentification
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
          return $this->redirectToRoute('render_with_access_denied_errors');
        }
        $product = new Product();
        $form = $this->createForm('sil16\AdminBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush($product);

            return $this->redirectToRoute('admin_product_index');
        }

        return $this->render('sil16AdminBundle:Product:new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing productCategory entity.
     *
     */
    public function editAction(Request $request, Product $product)
    {
        // Vérification de l'authentification
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
          return $this->redirectToRoute('render_with_access_denied_errors');
        }

        $editForm = $this->createForm('sil16\AdminBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "Le produit a été édité avec succès");
            return $this->redirectToRoute('admin_product_index');
        }

        return $this->render('sil16AdminBundle:Product:edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView()
        ));
    }


    // Change la valeur actif ou inactif d'un produit
    public function toggleActiveAction(Product $product)
    {
        // Vérification de l'authentification
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
          return $this->redirectToRoute('render_with_access_denied_errors');
        }

        $active_value = $product->getActive();
        $product->setActive(!$active_value);
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush($product);

        if(!$active_value == true){
          $message_value = "activé";
        } else {
          $message_value = "désactivé";
        }
        $this->addFlash('success', "Le produit a été $message_value avec succès");
        return $this->redirectToRoute('admin_product_index');
    }
}
