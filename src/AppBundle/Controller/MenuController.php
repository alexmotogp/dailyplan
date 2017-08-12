<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Menu;
use AppBundle\Entity\Category;

class MenuController extends Controller{
	public function getMenuAction() {
		$repository = $this->getDoctrine()->getRepository(Menu::class);
		$menu = $repository->findAll();
		$catRep = $this->getDoctrine()->getRepository(Category::class);
		$categories = $catRep->findAll(); 
		
		return $this->render('base/menu.html.twig', array('menu' => $menu, 'cat' => $categories));
	}
}