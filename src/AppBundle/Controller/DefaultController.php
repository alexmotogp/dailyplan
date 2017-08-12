<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Task;
use AppBundle\Entity\Menu;
use AppBundle\Form\TaskForm;
use AppBundle\Entity;
use AppBundle\Form\ReportForm;


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
	
	private function getAllTasks() {
		$repository = $this->getDoctrine()->getRepository(Task::class);
		$tasks = $repository->findAll();
		return $tasks;
	}
	
	/**
	 * @param string $dateFrom Date from
	 * @param string $dateTo Date to
	 * @param ExecutedEnum $executed Can be All|Executed|NoExecuted
	 * @return array of Tasks
	 */
	private function getTasksBetweenDate($dateFrom, $dateTo, $executed = ExecutedEnum::All)
	{
		if ($dateFrom == null) {
			$dateFrom = '1971-01-01 00:00:00';
		}
		if ($dateTo == null) {
			throw $this->createNotFoundException('No found tasks in this ranges');
		}
		$repository = $this->getDoctrine()->getRepository(Task::class);
		$em = $this->getDoctrine()->getManager();
		$qText = '  SELECT t
   					FROM AppBundle:Task t
    				WHERE t.executeData BETWEEN :date1 AND :date2';							
		$params = array(
				'date1' => $dateFrom,
				'date2' => $dateTo.' 23:59:59',
		);
		if ($executed !== ExecutedEnum::All) {
			$qText = $qText.' AND t.executed = :executed';
			$params['executed'] = $executed;			
		}
		$q = $em->createQuery($qText)->setParameters($params);
		$tasks = $q->getResult();
		return $tasks;
	}
	
	private function getTaskById($id) {
		if ($id == null) {
			throw $this->createNotFoundException('No found tasks in this ranges');
		}
		$repository = $this->getDoctrine()->getRepository(Task::class);		
		$tasks = $repository->find($id);
	}
	
	/* private function getMenu()
	{
		$repository = $this->getDoctrine()->getRepository(Menu::class);
		$menu = $repository->findAll();
		return $menu;
	} */
	
    /**
     * @Route("/{type}", name="homepage", requirements={"type":"actual|exec|all"})
     */
    public function indexAction(Request $request, $type = 'actual')
    {	
    	$date = date('Y-m-d');    	
    	if($type == 'actual') {
    		$this->contentHeader = "Актуальные";
    		$tasks = $this->getTasksBetweenDate(null, $date, ExecutedEnum::NoExecuted);
    	} elseif ($type == 'exec') {
    		$this->contentHeader = "Выполненные";
    		$tasks = $this->getTasksBetweenDate(null, $date, ExecutedEnum::Executed);
    	} elseif ($type == 'all') {
    		$this->contentHeader = "Все";
    		$tasks = $this->getTasksBetweenDate(null, $date);
    	}
    	  	
    	return $this->render('base/index.html.twig', array('tasks' => $tasks, 'contentHeader' => $this->contentHeader));
    }
    
    /**
     * @Route("/tasks/{type}", name="tasks")
     */
    public function tasksAction(Request $request, $type = 'actual')
    {    	
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
    	return $this->render('base/index.html.twig', array('tasks' => $tasks, 'contentHeader' => $this->contentHeader));
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
    		$task->setUser($this->getUser());
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($task);
    		$em->flush();
    		
    		return $this->redirectToRoute('homepage');
    	}
    	    	
    	return $this->render('base/newtask.html.twig', array('form' => $form->createView()));
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
    
    /**
     *@Route("/del-task/{id}", name="del-task")
     */
    public function delTaskAction($id) {
    	$em = $this->getDoctrine()->getManager();
    	$task = $em->getRepository(Task::class)->find($id);
    	 
    	if(!$task) {
    		throw $this->createNotFoundException('No task with id:'.$id);
    	}
    	
    	$em->remove($task);
    	$em->flush();
    	
    	return $this->redirectToRoute('homepage');
    }
    
    /**
     *@Route("/edit-task/{id}", name="edit-task")
     */
    public function editTaskAction(Request $request, $id) {
    	$em = $this->getDoctrine()->getManager();
    	$task = $em->getRepository(Task::class)->find($id);
    	$form = $this->createForm(TaskForm::class, $task);
    	
    	$form->handleRequest($request);
    	 
    	if ($form->isSubmitted() && $form->isValid()) {
    		$data = $form->getData();
    		$task->setCreateData(new \DateTime());
    		$task->setExecuted(false);
    		$task->setUser($this->getUser());
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($task);
    		$em->flush();
    	
    		return $this->redirectToRoute('homepage');
    	}
    	 
    	return $this->render('base/newtask.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * @Route("/report", name="report")
     */
    public function reportAction(Request $request) {
    	$form = $this->createForm(ReportForm::class);
    	
    	$form->handleRequest($request);
    	
    	if ($form->isSubmitted() && $form->isValid()) {
    		$data = $form->getData();
    		$tasks = $this->getTasksBetweenDate($data['DateFrom']->format('Y-m-d'), $data['DateTo']->format('Y-m-d'), $data['isExecuted']);
    	} else {
    		$tasks = null;
    	}
    	
    	return $this->render('base/report.html.twig', array('form' => $form->createView(), 'tasks' => $tasks));
    }
}
