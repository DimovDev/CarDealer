<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Car;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{

	/**
	 * @Route("/", name="homepage",methods={"GET"})
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function indexAction(Request $request)
    {
//    	die('here');exit;

//	    $cars=$this
//		    ->getDoctrine()
//		    ->getRepository(Car::class);

	    return $this->render('base.html.twig'
//		    ,['cars'=>$cars]
	    );
    }
}
