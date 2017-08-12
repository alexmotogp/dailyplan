<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\OneToMany(targetEntity="Task", mappedBy="user")
	 */
	private $tasks;
	
//	private $notices;

	/**
     * @return Task $tasks
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @return the $notices
     */
  /*   public function getNotices()
    {
        return $this->notices;
    } */

    /**
     * @param Task $tasks
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * @param field_type $notices
     */
  /*   public function setNotices($notices)
    {
        $this->notices = $notices;
    } */

//     public function __construct()
// 	{
// 		parent::__construct();
// 		// your own logic
// 	}
}