<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Task;
use AppBundle\Entity\Menu;
use AppBundle\Form\TaskForm;

class DefaultController extends Controller
{
	private function getTasks(\DateTime $date = null) {
		$repository = $this->getDoctrine()->getRepository(Task::class);
		if ($date === null) {
			$tasks = $repository->findAll();
		} else {	
			$tasks = $repository->findBy(array('executeData' => $date));
		}
		return $tasks;
	}
	
	private function getMenu()
	{
		$repository = $this->getDoctrine()->getRepository(Menu::class);
		$menu = $repository->findAll();
		return $menu;
	}
	
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {	
    	$tasks = $this->getTasks(new \DateTime());
    	$menu = $this->getMenu();
    	return $this->render('base/index.html.twig', array('tasks' => $tasks, 'menu' => $menu));
    }
    
    /**
     * @Route("/tasks", name="tasks")
     */
    public function tasksAction(Request $request)
    {
    	$tasks = $this->getTasks(); 
    	$menu = $this->getMenu();
    	return $this->render('base/index.html.twig', array('tasks' => $tasks, 'menu' => $menu));
    }
    
    /**
     * @Route("/newtask", name="newtask")
     */
    public function newtaskAction(Request $request) {
    	
    	$task = new Task();
    	
    	/* $form = $this->createFormBuilder($task, array('action' => $this->generateUrl('newtask')))
    	->add("name", TextType::class)
    	->add("description", TextareaType::class)
    	->add("executeData", DateType::class)
    	->add("submit", SubmitType::class, array('label' => "Создать"))
    	->getForm(); */
    	
    	$form = $this->createForm(TaskForm::class, $task);
    	
    	$form->handleRequest($request);
    	
    	if ($form->isSubmitted() && $form->isValid()) {    		    	
    		$data = $form->getData();
    		$task->setCreateData(new \DateTime());  	
    		$task->setFinishData(new \DateTime());	
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($task);
    		$em->flush();
    		
    		return $this->redirectToRoute('tasks');
    	}
    	
    	$menu = $this->getMenu();
    	return $this->render('base/newtask.html.twig', array('form' => $form->createView(), 'menu' => $menu));
    }
}
