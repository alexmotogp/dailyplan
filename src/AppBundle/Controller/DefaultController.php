<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use AppBundle\Entity\Task;
use AppBundle\Entity\Menu;

class DefaultController extends Controller
{
	private function getTasks() {
		$repository = $this->getDoctrine()->getRepository(Task::class);
		$tasks = $repository->findAll();
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
        // replace this example code with whatever you need
 /*        return $this->render('base/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]); */
    	
    	$tasks = $this->getTasks();
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
    	
    	$form = $this->createFormBuilder(null, array('action' => $this->generateUrl('newtask')))
    	->add("Name", TextType::class)
    	->add("Desc", TextareaType::class)
    	->add("Exdate:", DateType::class)
    	->getForm();
    	
    	$form->handleRequest($request);
    	
    	if ($form->isSubmitted() && $form->isValid()) {
    		$task = new Task();    		
    		$data = $form->getData();
    		$task->setName($data['name']);
    		$task->setDescription($data['desc']);
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($task);
    		$em->flush();
    		
    		return $this->redirectToRoute('tasks');
    	}
    	
    	$menu = $this->getMenu();
    	return $this->render('base/newtask.html.twig', array('form' => $form->createView(), 'menu' => $menu));
    }
}
