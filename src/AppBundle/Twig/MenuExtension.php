<?php

namespace AppBundle\Twig;

use Symfony\Component\DependencyInjection\Tests\Compiler\PrivateConstructor;
use AppBundle\Controller\MenuController;
use AppBundle\Controller\AppBundle\Controller;

class MenuExtension extends \Twig_Extension {
	public function getFunctions() {
		return (array(
				new \Twig_SimpleFunction('dp_menu', array($this, 'getMenu'))
		));
	}
	
	public function getMenu() {		
		return 'My menu';		
	}
}