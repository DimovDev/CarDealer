<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sale;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Sale controller.
 *
 * @Route("sale")
 */
class SaleController extends Controller
{
    /**
     * Lists all sale entities.
     *
     * @Route("/", name="sale_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sales = $em->getRepository('AppBundle:Sale')->findAll();

        return $this->render('sale/index.html.twig', array(
            'sales' => $sales,
        ));
    }

    /**
     * Creates a new sale entity.
     *
     * @Route("/new", name="sale_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $sale = new Sale();
        $form = $this->createForm('AppBundle\Form\SaleType', $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sale);
            $em->flush();

            return $this->redirectToRoute('sale_show', array('id' => $sale->getId()));
        }

        return $this->render('sale/new.html.twig', array(
            'sale' => $sale,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sale entity.
     *
     * @Route("/{id}", name="sale_show")
     * @Method("GET")
     */
    public function showAction(Sale $sale)
    {
        $deleteForm = $this->createDeleteForm($sale);

        return $this->render('sale/show.html.twig', array(
            'sale' => $sale,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sale entity.
     *
     * @Route("/{id}/edit", name="sale_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Sale $sale)
    {
        $deleteForm = $this->createDeleteForm($sale);
        $editForm = $this->createForm('AppBundle\Form\SaleType', $sale);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sale_edit', array('id' => $sale->getId()));
        }

        return $this->render('sale/edit.html.twig', array(
            'sale' => $sale,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sale entity.
     *
     * @Route("/{id}", name="sale_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Sale $sale)
    {
        $form = $this->createDeleteForm($sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sale);
            $em->flush();
        }

        return $this->redirectToRoute('sale_index');
    }

    /**
     * Creates a form to delete a sale entity.
     *
     * @param Sale $sale The sale entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sale $sale)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sale_delete', array('id' => $sale->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
