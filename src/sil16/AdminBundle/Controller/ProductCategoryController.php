<?php

namespace sil16\AdminBundle\Controller;

use sil16\VitrineBundle\Entity\ProductCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Productcategory controller.
 *
 */
class ProductCategoryController extends Controller
{
    /**
     * Lists all productCategory entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $product_categories = $em->getRepository('sil16VitrineBundle:ProductCategory')->findAll();

        return $this->render('sil16AdminBundle:ProductCategory:index.html.twig', array(
            'product_categories' => $product_categories,
        ));
    }

    /**
     * Creates a new productCategory entity.
     *
     */
    public function newAction(Request $request)
    {
        $product_category = new ProductCategory();
        $form = $this->createForm('sil16\AdminBundle\Form\ProductCategoryType', $product_category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product_category);
            $em->flush($product_category);

            return $this->redirectToRoute('admin_product_category_edit', array('id' => $product_category->getId()));
        }

        return $this->render('sil16AdminBundle:ProductCategory:new.html.twig', array(
            'product_category' => $product_category,
            'form' => $form->createView(),
        ));
    }
    //
    // /**
    //  * Finds and displays a productCategory entity.
    //  *
    //  */
    // public function showAction(ProductCategory $product_category)
    // {
    //     $deleteForm = $this->createDeleteForm($product_category);
    //
    //     return $this->render('sil16AdminBundle:ProductCategory:show.html.twig', array(
    //         'product_category' => $product_category,
    //         'delete_form' => $deleteForm->createView(),
    //     ));
    // }

    /**
     * Displays a form to edit an existing productCategory entity.
     *
     */
    public function editAction(Request $request, ProductCategory $product_category)
    {

        $deleteForm = $this->createDeleteForm($product_category);
        $editForm = $this->createForm('sil16\AdminBundle\Form\ProductCategoryType', $product_category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_product_category_edit', array('id' => $product_category->getId()));
        }

        return $this->render('sil16AdminBundle:ProductCategory:edit.html.twig', array(
            'product_category' => $product_category,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a productCategory entity.
     *
     */
    public function deleteAction(Request $request, ProductCategory $product_category)
    {
        $form = $this->createDeleteForm($product_category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product_category);
            $em->flush($product_category);
        }

        return $this->redirectToRoute('admin_product_category_index');
    }

    /**
     * Creates a form to delete a productCategory entity.
     *
     * @param ProductCategory $product_category The productCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ProductCategory $product_category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_product_category_delete', array('id' => $product_category->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
