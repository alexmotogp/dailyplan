<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
 /*        return $this->render('base/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]); */
    	return $this->render('base/index.html.twig', array('var' => "First Page!"));
    }
    
    /**
     * @Route("/tasks", name="tasks")
     */
    public function tasksAction(Request $request)
    {
    	return $this->render('base/index.html.twig', array('var' => "All OK!"));
    }
    
    /**
     * @Route("/newtask", name="newtask")
     */
    public function newtaskAction(Request $request) {
    	
    	$form = $this->createFormBuilder(null, array('action' => '/tasks'))
    	->add("name", TextType::class)
    	->add("desk", TextareaType::class)
    	->getForm();
    	
    	return $this->render('base/newtask.html.twig', array('form' => $form->createView()));
    }
}
