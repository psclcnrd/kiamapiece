<?php

/**
 * Classe de gestion des status des pièces
 * 
 * @author CONRAD pascal
 * @version 1.0 - 10/04/2014
 *
 */

namespace Search\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Table des status
 *
 * @ORM\Entity
 * @ORM\Table(name="Status")
 *
 * @author CONRAD Pascal
 */

class Status {
	/**
	 * @ORM\Id
	 * @ORM\Column(name="Id",type="bigint")
	 */
	protected $id;
	
	/** @ORM\Column(name="Description",type="String",length=120) */
	protected $Description;
	
	/**
	 * Constructeur de classe
	 */
	public function __construct() {
	
	}
	
	/**
	 * Magic setter !
	 * @param string $property
	 * @param any $value
	 */
	public function __set($property,$value) {
		$this->$property=$value;
	}
	
	/**
	 * Magic getter !
	 * @param string $property
	 */
	public function __get($property) {
		return $this->$property;
	}	
}

?>