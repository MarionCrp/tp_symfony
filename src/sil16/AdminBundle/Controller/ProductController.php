<?php

namespace sil16\AdminBundle\Controller;

use sil16\VitrineBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('sil16VitrineBundle:Product')->findAll();

        return $this->render('sil16AdminBundle:Product:index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Creates a new productCategory entity.
     *
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('sil16\AdminBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush($product);

            return $this->redirectToRoute('admin_product_edit', array('id' => $product->getId()));
        }

        return $this->render('sil16AdminBundle:Product:new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }
    //
    // /**
    //  * Finds and displays a productCategory entity.
    //  *
    //  */
    // public function showAction(Product $product)
    // {
    //     $deleteForm = $this->createDeleteForm($product);
    //
    //     return $this->render('sil16AdminBundle:Product:show.html.twig', array(
    //         'product' => $product,
    //         'delete_form' => $deleteForm->createView(),
    //     ));
    // }

    /**
     * Displays a form to edit an existing productCategory entity.
     *
     */
    public function editAction(Request $request, Product $product)
    {

        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('sil16\AdminBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "Le produit a été édité avec succès");
            return $this->redirectToRoute('admin_product_edit', array('id' => $product->getId()));
        }

        return $this->render('sil16AdminBundle:Product:edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a productCategory entity.
     *
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush($product);
        }

        return $this->redirectToRoute('admin_product_index');
    }

    /**
     * Creates a form to delete a productCategory entity.
     *
     * @param Product $product The productCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
