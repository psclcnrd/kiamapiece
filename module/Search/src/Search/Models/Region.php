<?php

/**
 * Classe de gestion des régions
 * 
 * @author CONRAD pascal
 * @version 1.0 - 23/04/2014 sur DB Ver. 1.1
 *
 */

namespace Search\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Table des Marques
 *
 * @ORM\Entity
 * @ORM\Table(name="Region")
 *
 * @author CONRAD Pascal
 */

class Region {
	/**
	 * @ORM\Id
	 * @ORM\Column(name="Id",type="bigint")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/** @ORM\Column(name="Description",type="string",length=120) */
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