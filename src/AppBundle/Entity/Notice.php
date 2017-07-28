<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\BooleanType;

/**
 * @ORM\Entity
 * @ORM\Table(name="notices")
 */
class Notice {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;    
    
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $notice;
    
    /** @ORM\Column(type="integer") */
    private $userId;
    
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $notice
     */
    public function getNotice()
    {
        return $this->notice;
    }

    /**
     * @return the $userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param field_type $notice
     */
    public function setNotice($notice)
    {
        $this->notice = $notice;
    }

    /**
     * @param field_type $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    
}