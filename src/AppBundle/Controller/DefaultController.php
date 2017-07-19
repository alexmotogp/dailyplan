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
use AppBundle\Entity\AppBundle\Entity;

class DefaultController extends Controller
{
	private $contentHeader = "";
	
	private function getTasks($date = null, $executed = FALSE) {
		$repository = $this->getDoctrine()->getRepository(Task::class);
		if ($date === null) {
			$tasks = $repository->findAll();
		} else {	
			//$tasks = $repository->findBy(array('executeData' => $date));			
			$em = $this->getDoctrine()->getManager();
			$q = $em->createQuery(
					'
					SELECT t
   					FROM AppBundle:Task t
    				WHERE t.executeData BETWEEN :date AND :date1
					AND t.executed = :executed
					'
					)->setParameters(array('date' => '1971-01-01 00:00:00', 'date1' => $date.' 23:59:59', 'executed' => $executed));
			$tasks = $q->getResult();
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
     * @Route("/{type}", name="homepage", requirements={"type":"actual|exec|all"})
     */
    public function indexAction(Request $request, $type = 'actual')
    {	
    	$date = date('Y-m-d');    	
    	//$tasks = $this->getTasks($date);
    	if($type == 'actual') {
    		$this->contentHeader = "Актуальные";
    		$tasks = $this->getTasks($date, FALSE);
    	} elseif ($type == 'exec') {
    		$this->contentHeader = "Выполненные";
    		$tasks = $this->getTasks($date, TRUE);
    	} elseif ($type == 'all') {
    		$this->contentHeader = "Все";
    		$tasks = $this->getTasks($date);
    	}
    	$menu = $this->getMenu();   	
    	return $this->render('base/index.html.twig', array('tasks' => $tasks, 'menu' => $menu, 'contentHeader' => $this->contentHeader));
    }
    
    /**
     * @Route("/tasks/{type}", name="tasks")
     */
    public function tasksAction(Request $request, $type = 'actual')
    {    	
    	$menu = $this->getMenu();
    	if($type == 'actual') {
    		$this->contentHeader = "Актуальные";
    		$tasks = $this->getTasks(null, 'FALSE');
    	} elseif ($type == 'exec') {
    		$this->contentHeader = "Выполненные";
    		$tasks = $this->getTasks(null, 'TRUE');
    	} elseif ($type == 'all') {
    		$this->contentHeader = "Все";
    		$tasks = $this->getTasks();
    	}
    	return $this->render('base/index.html.twig', array('tasks' => $tasks, 'menu' => $menu, 'contentHeader' => $this->contentHeader));
    }
    
    /**
     * @Route("/newtask", name="newtask")
     */
    public function newtaskAction(Request $request) {
    	
    	$task = new Task();
    	$task->setExecuteData(new \DateTime());
    	
    	$form = $this->createForm(TaskForm::class, $task);
    	
    	$form->handleRequest($request);
    	
    	if ($form->isSubmitted() && $form->isValid()) {    		    	
    		$data = $form->getData();
    		$task->setCreateData(new \DateTime());  	
    		$task->setExecuted(false);
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($task);
    		$em->flush();
    		
    		return $this->redirectToRoute('tasks');
    	}
    	
    	$menu = $this->getMenu();
    	return $this->render('base/newtask.html.twig', array('form' => $form->createView(), 'menu' => $menu));
    }
    
    /**
     *@Route("/update/{id}", name="update") 
     */
    public function updateTaskAction(Request $request, $id) {    	
    	$em = $this->getDoctrine()->getManager();
    	$task = $em->getRepository(Task::class)->find($id);
    	
    	if(!$task) {
    		throw $this->createNotFoundException('No task with id:'.$id);
    	}
    	
    	$task->setFinishData(new \DateTime());
    	$task->setExecuted(true);
    	$em->flush();
    	
    	return $this->redirectToRoute('homepage');
    }
}
