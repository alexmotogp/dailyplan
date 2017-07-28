<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Menu;

class MenuController extends Controller{
	public function getMenuAction() {
		$repository = $this->getDoctrine()->getRepository(Menu::class);
		$menu = $repository->findAll();
		
		return $this->render('base/menu.html.twig', array('menu' => $menu));
	}
}