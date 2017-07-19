<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\BooleanType;

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
	 * @Assert\NotBlank()
	 */
	private $name;
	/**
	 * @ORM\Column(type="text")
	 * @Assert\NotBlank()
	 */
	private $description;
	/**
	 * @ORM\Column(type="datetime")
	 */
	private $createData;
	/**
	 * @ORM\Column(type="datetime")
	 */
	private $executeData;
	/**
	 * @ORM\Column(type="datetime")
	 */
	private $finishData;
	
	/**
	 * @ORM\Column(type="boolean")
	 */
	private $executed;
	
	//private $user;
	
	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function setDescription($desc) {
		$this->description = $desc;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getExecuteData() {
		return $this->executeData;
	}
	
	public function setExecuteData(\DateTime $date) {
		$this->executeData = $date;
	}
	
	public function getCreateData() {
		return $this->createData;
	}
	
	public function setCreateData(\DateTime $date) {
		$this->createData = $date;
	}
	
	public function getFinishData() {
		return $this->finishData;
	}
	
	public function setFinishData(\DateTime $date) {
		$this->finishData = $date;
	}
	
	public function getExecuted() {
		return $this->executed;
	}
	
	public function setExecuted($exec) {
		$this->executed = $exec;
	}
}


?>