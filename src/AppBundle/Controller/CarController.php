<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Car;
use AppBundle\Form\CarType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Car controller.
 *
 * @Route("car")
 */
class CarController extends Controller
{
	/**
	 * Lists all car entities.
	 *
	 * @Route("/", name="car_index",methods={"GET"})
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function indexAction(Request $request): \Symfony\Component\HttpFoundation\Response
	{
		$em = $this->getDoctrine()->getManager();

		$cars = $em->getRepository(Car::class)->findAll();

		/**
		 * @ var $paginator\Knp\Component\Pager\Paginator
		 */
		$paginator = $this->get('knp_paginator');

		$result = $paginator->paginate(
			$cars,
			$request->query->getInt('page', 1),
			$request->query->getInt('limit', 10)
		);

		return $this->render('car/index.html.twig', array(
			'cars' => $result));
	}
	/**
	 * Lists all car entities sorted by criteria.
	 *
	 * @Route("/sort", name="car_sort",methods={"GET"})
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function findByCriteria(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$cars = $em->getRepository(Car::class)->
		sortCartByMake();

		/**
		 * @ var $paginator\Knp\Component\Pager\Paginator
		 */
		$paginator = $this->get('knp_paginator');

		$result = $paginator->paginate(
			$cars,
			$request->query->getInt('page', 1),
			$request->query->getInt('limit', 10)
		);

		return $this->render('car/sort.html.twig', array(
			'cars' => $result));
	}

	/**
	 * Creates a new car entity.
	 *
	 * @Route("/new", name="car_new",methods={"GET","POST"})
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function newAction(Request $request)
	{
		$car = new Car();

		$form = $this->createForm(CarType::class, $car);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($car);
			$em->flush();

			return $this->redirectToRoute('car_show'
				, array('id' => $car->getId())
			);
		}

		return $this->render('car/new.html.twig', array(
			'car' => $car,
			'form' => $form->createView(),
		));
	}

	/**
	 * Finds and displays a car entity.
	 *
	 * @Route("/{id}", name="car_show",methods={"GET"})
	 *
	 * @param Car $car
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function showAction(Car $car)
	{
		$deleteForm = $this->createDeleteForm($car);

		return $this->render('car/show.html.twig', array(
			'car' => $car,
			'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	 * Displays a form to edit an existing car entity.
	 *
	 * @Route("/{id}/edit", name="car_edit",methods={"GET", "POST"})
	 */
	public function editAction(Request $request, Car $car)
	{
		$deleteForm = $this->createDeleteForm($car);
		$editForm = $this->createForm('AppBundle\Form\CarType', $car);
		$editForm->handleRequest($request);

		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('car_edit', array('id' => $car->getId()));
		}

		return $this->render('car/edit.html.twig', array(
			'car' => $car,
			'edit_form' => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	 * Deletes a car entity.
	 *
	 * @Route("/{id}", name="car_delete",methods={"DELETE"})
	 * @param Request $request
	 * @param Car $car
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */

	public function deleteAction(Request $request, Car $car): \Symfony\Component\HttpFoundation\RedirectResponse
	{
		$form = $this->createDeleteForm($car);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($car);
			$em->flush();
		}

		return $this->redirectToRoute('car_index');
	}

	/**
	 * Creates a form to delete a car entity.
	 *
	 * @param Car $car The car entity
	 *
	 * @return \Symfony\Component\Form\FormInterface
	 */
	private function createDeleteForm(Car $car): \Symfony\Component\Form\FormInterface
	{
		$result= $this->createFormBuilder()
			->setAction($this->generateUrl('car_delete', array('id' => $car->getId())))
			->setMethod('DELETE')
			->getForm();
		return $result;
	}
}
