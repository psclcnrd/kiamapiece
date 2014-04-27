<?php

/**
 * Classe de gestion des Villes
 * 
 * @author CONRAD pascal
 * @version 1.0 - 26/04/2014 sur DB Ver. 1.2
 *
 */

namespace Search\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Table des Villes. Elle ne sert juste qu'a valider la saisie de l'utilisateur
 *
 * @ORM\Entity
 * @ORM\Table(name="Towns")
 *
 * @author CONRAD Pascal
 */

class Towns {
	/**
	 * @ORM\Id
	 * @ORM\Column(name="Id",type="bigint")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/** @ORM\Column(name="CP",type="integer") */
	protected $CP;
	
	/** @ORM\Column(name="Name",type="string",length=250) */
	protected $Name;
	
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