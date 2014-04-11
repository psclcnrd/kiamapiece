<?php

/**
 * Classe de gestion des logs du site
 *
 * @author CONRAD pascal
 * @version 1.0 - 10/04/2014
 *
 */

namespace Search\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Table des Logs
 *
 * @ORM\Entity
 * @ORM\Table(name="Logs")
 *
 * @author CONRAD Pascal
 */

class Logs {
	/**
	 * @ORM\Id
	 * @ORM\Column(name="Id",type="bigint")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/** @ORM\Column(type="bigint") */
	protected $UserId;
	
	/** @ORM\Column(type="string",length=200) */
	protected $Operation;
	
	/** @ORM\Column(type="datetime") */
	protected $OperationDate;
	
	/** @ORM\Column(type="bigint") */
	protected $RequestId;
	
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