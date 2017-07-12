<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="task")
 */
class Task {
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $name;
	/**
	 * @ORM\Column(type="text")
	 */
	private $desctiplion;
	//private $user;
	
	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getDescription() {
		return $this->name;
	}
	
	public function setDescription($desc) {
		$this->name = $desc;
	}
	
	public function getId() {
		return $this->id;
	}
	
}


?>