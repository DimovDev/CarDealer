<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Supplier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\SupplierType;

/**
 * Supplier controller.
 *
 * @Route("supplier")
 */
class SupplierController extends Controller
{
    /**
     * Lists all supplier entities.
     *
     * @Route("/", name="supplier_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $suppliers = $em->getRepository('AppBundle:Supplier')->findAll();

        return $this->render('supplier/index.html.twig', array(
            'suppliers' => $suppliers,
        ));
    }
	/**
	 * Lists all supplier entities order by abroad.
	 *
	 * @Route("/sort", name="supplier_sort")
	 * @Method({"GET","POST"})
	 */
	public function findByCriteria(Request $request): \Symfony\Component\HttpFoundation\Response
	{
		$orderByAbroad=$request->get('orderByAbroad') ?? 'True';
		$orderByAbroad='True'===$orderByAbroad ? 'False' : 'True';
		$em = $this->getDoctrine()->getManager();

		$suppliers = $em->getRepository('AppBundle:Supplier')
			->sortSupplierByAbroad($orderByAbroad);

		return $this->render('supplier/sort.twig',array(
			'suppliers' => $suppliers,'orderByAbroad'=>$orderByAbroad
		));
	}
//$ageOrder = $request->get('ageOrder') ?? 'ASC';  // get the current ageOrder
//$ageOrder = 'ASC' === $ageOrder ? 'DESC' : 'ASC';    // toggle it
//$em = $this->getDoctrine()->getManager();
//
//$customers = $em->getRepository('AppBundle:Customer')






	/**
	 * Creates a new supplier entity.
	 *
	 * @Route("/new", name="supplier_new")
	 * @Method({"GET", "POST"})
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
    public function newAction(Request $request)
    {
        $supplier = new Supplier();
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($supplier);
            $em->flush();

            return $this->redirectToRoute('supplier_show', array('id' => $supplier->getId()));
        }

        return $this->render('supplier/new.html.twig', array(
            'supplier' => $supplier,
            'form' => $form->createView(),
        ));
    }

	/**
	 * Finds and displays a supplier entity.
	 *
	 * @Route("/{id}", name="supplier_show")
	 * @Method("GET")
	 * @param Supplier $supplier
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function showAction(Supplier $supplier)
    {
        $deleteForm = $this->createDeleteForm($supplier);

        return $this->render('supplier/show.html.twig', array(
            'supplier' => $supplier,
            'delete_form' => $deleteForm->createView(),
        ));
    }

	/**
	 * Displays a form to edit an existing supplier entity.
	 *
	 * @Route("/{id}/edit", name="supplier_edit")
	 * @Method({"GET", "POST"})
	 * @param Request $request
	 * @param Supplier $supplier
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
    public function editAction(Request $request, Supplier $supplier)
    {
        $deleteForm = $this->createDeleteForm($supplier);
        $editForm = $this->createForm('AppBundle\Form\SupplierType', $supplier);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('supplier_edit', array('id' => $supplier->getId()));
        }

        return $this->render('supplier/edit.html.twig', array(
            'supplier' => $supplier,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

	/**
	 * Deletes a supplier entity.
	 *
	 * @Route("/{id}", name="supplier_delete")
	 * @Method("DELETE")
	 * @param Request $request
	 * @param Supplier $supplier
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
    public function deleteAction(Request $request, Supplier $supplier): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $form = $this->createDeleteForm($supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($supplier);
            $em->flush();
        }

        return $this->redirectToRoute('supplier_index');
    }

	/**
	 * Creates a form to delete a supplier entity.
	 *
	 *
	 *
	 * @param Supplier $supplier
	 * @return \Symfony\Component\Form\Form The form
	 */
    private function createDeleteForm(Supplier $supplier): \Symfony\Component\Form\Form
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('supplier_delete', array('id' => $supplier->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
