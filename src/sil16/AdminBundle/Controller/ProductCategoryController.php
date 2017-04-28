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
        // Vérification de l'authentification
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
          return $this->redirectToRoute('render_with_access_denied_errors');
        }
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
        // Vérification de l'authentification
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
          return $this->redirectToRoute('render_with_access_denied_errors');
        }
        $product_category = new ProductCategory();
        $form = $this->createForm('sil16\AdminBundle\Form\ProductCategoryType', $product_category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product_category);
            $em->flush($product_category);
            $this->addFlash('success', "La catégorie a été ajoutée avec succès");
            return $this->redirectToRoute('admin_product_category_index');
        }

        return $this->render('sil16AdminBundle:ProductCategory:new.html.twig', array(
            'product_category' => $product_category,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing productCategory entity.
     *
     */
    public function editAction(Request $request, ProductCategory $product_category)
    {
        // Vérification de l'authentification
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
          return $this->redirectToRoute('render_with_access_denied_errors');
        }

        $deleteForm = $this->createDeleteForm($product_category);
        $editForm = $this->createForm('sil16\AdminBundle\Form\ProductCategoryType', $product_category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_product_category_index');
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
        // Vérification de l'authentification
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
          return $this->redirectToRoute('render_with_access_denied_errors');
        }

        $form = $this->createDeleteForm($product_category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // On vérifie que la catégorie n'a pas d'objet associé. Sinon elle ne peut pas être supprimée, et on affiche un flash
            if(count($product_category->getProducts()) > 0){
              $this->addFlash('danger', "La catégorie n'a pas pu être supprimée car des produits lui sont associés");
            } else {
              $em = $this->getDoctrine()->getManager();
              $em->remove($product_category);
              $em->flush($product_category);
              $this->addFlash('success', "La catégorie a été supprimée avec succès");
            }
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
