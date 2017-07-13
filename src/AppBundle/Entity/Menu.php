<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="menu")
 */
class Menu {
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	/**
	 * @ORM\Column(type="string", length=20)
	 */
	private $name;
	/**
	 * @ORM\Column(type="string", length=20)
	 */
	private $link;
	/**
	 * @ORM\Column(type="boolean")
	 */
	private $isActive;
	
	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getLink() {
		return $this->link;
	}
	
	public function setLink($link) {
		$this->link = $link;
	}
	
	public function getIsActive() {
		return $this->isActive;
	}
	
	public function setIsActive($isActive) {
		$this->isActive = $isActive;
	}
}