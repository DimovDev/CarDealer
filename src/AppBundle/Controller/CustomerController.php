<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use AppBundle\Repository\Customers;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\CustomerType;

/**
 * Customer controller.
 *
 * @Route("customer")
 */
class CustomerController extends Controller
{
	/**
	 * Lists all customer entities.
	 *
	 * @Route("/", name="customer_index")
	 * @Method("GET")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$customers = $em->getRepository('AppBundle:Customer')->findAll();

		return $this->render('customer/index.html.twig', array(
			'customers' => $customers,
		));
	}

	/**
	 * Lists sorted customer by criteria.
	 *
	 * @Route("/sort", name="customer_sort", methods={"GET","POST"})
	 *
	 *
	 * @param $customers
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function findByCriteria(Request $request)
	{
		$ageOrder = $request->get('ageOrder') ?? 'ASC';  // get the current ageOrder
		$ageOrder = 'ASC' === $ageOrder ? 'DESC' : 'ASC';    // toggle it
		$em = $this->getDoctrine()->getManager();

		$customers = $em->getRepository('AppBundle:Customer')

			->sortCustomerByBirthDate($ageOrder);




		return $this->render('customer/sort.html.twig', array(
			'ageOrder' => $ageOrder,'customers' => $customers,
		));
	}

	/**
	 * Creates a new customer entity.
	 *
	 * @Route("/new", name="customer_new")
	 * @Method({"GET", "POST"})
	 */
	public function newAction(Request $request)
	{
		$customer = new Customer();
		$form = $this->createForm(CustomerType::class, $customer);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($customer);
			$em->flush();

			return $this->redirectToRoute('customer_show', array('id' => $customer->getId()));
		}

		return $this->render('customer/new.html.twig', array(
			'customer' => $customer,
			'form' => $form->createView(),
		));
	}

	/**
	 * Finds and displays a customer entity.
	 *
	 * @Route("/{id}", name="customer_show")
	 * @Method("GET")
	 */
	public function showAction(Customer $customer)
	{
		$deleteForm = $this->createDeleteForm($customer);

		return $this->render('customer/show.html.twig', array(
			'customer' => $customer,
			'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	 * Displays a form to edit an existing customer entity.
	 *
	 * @Route("/{id}/edit", name="customer_edit")
	 * @Method({"GET", "POST"})
	 */
	public function editAction(Request $request, Customer $customer)
	{
		$deleteForm = $this->createDeleteForm($customer);
		$editForm = $this->createForm('AppBundle\Form\CustomerType', $customer);
		$editForm->handleRequest($request);

		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('customer_edit', array('id' => $customer->getId()));
		}

		return $this->render('customer/edit.html.twig', array(
			'customer' => $customer,
			'edit_form' => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	 * Deletes a customer entity.
	 *
	 * @Route("/{id}", name="customer_delete")
	 * @Method("DELETE")
	 * @param Request $request
	 * @param Customer $customer
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function deleteAction(Request $request, Customer $customer): \Symfony\Component\HttpFoundation\RedirectResponse
	{
		$form = $this->createDeleteForm($customer);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($customer);
			$em->flush();
		}

		return $this->redirectToRoute('customer_index');
	}

	/**
	 * Creates a form to delete a customer entity.
	 *
	 * @param Customer $customer The customer entity
	 *
	 * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
	 */
	private function createDeleteForm(Customer $customer)
	{
		return $this->createFormBuilder()
			->setAction($this->generateUrl('customer_delete', array('id' => $customer->getId())))
			->setMethod('DELETE')
			->getForm();
	}


}
