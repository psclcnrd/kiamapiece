<?php

/**
 * Classe de controle des nouveaux utilisateurs
 * 
 * @author CONRAD pascal
 * @version 1.0 - 30/12/2014
 *
 */

namespace Search\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Table des control nouveaux utilisateurs
 *
 * @ORM\Entity
 * @ORM\Table(name="ControlNewUsers")
 *
 * @author CONRAD Pascal
 */

class ControlNewUsers {
	/**
	 * @ORM\Id
	 * @ORM\Column(name="Id",type="string",length=40)
	 */
	protected $id;
	
	/** @ORM\Column(name="UserId",type="integer") */
	protected $UserId;
	
	/** @ORM\Column(name="DateRequest",type="integer") */
	protected $DateRequest;

	/**
	 * Set $id value
	 * @param string $id
	 * @return ControlNewUsers
	 */
	public function setId($id) {
	  $this->id=$id;
	  return $this;
	}
	 
	/**
	 * get $id value
	 * @return string
	 */
	public function getId() {
	  return $this->id;
	}

	/**
	 * Set $UserId value
	 * @param integer $UserId
	 * @return ControlNewUsers
	 */
	public function setUserId($UserId) {
	  $this->UserId=$UserId;
	  return $this;
	}
	 
	/**
	 * get $UserId value
	 * @return integer
	 */
	public function getUserId() {
	  return $this->UserId;
	}
	  
	/**
	 * Set $DateRequest value
	 * @param integer $DateRequest
	 * @return ControlNewUsers
	 */
	public function setDateRequest($DateRequest) {
	  $this->DateRequest=$DateRequest;
	  return $this;
	}
	 
	/**
	 * get $DateRequest value
	 * @return integer
	 */
	public function getDateRequest() {
	  return $this->DateRequest;
	}
	
}
