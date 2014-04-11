<?php

/**
 * Classe de gestion des demandes
 *
 * @author CONRAD pascal
 * @version 1.0 - 10/04/2014
 *
 */

namespace Search\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Table des Requêtes
 *
 * @ORM\Entity
 * @ORM\Table(name="Request")
 *
 * @author CONRAD Pascal
 */

class Request {
	/**
	 * @ORM\Id
	 * @ORM\Column(name="Id",type="bigint")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/** @ORM\Column(type="bigint") */
	protected $UserDepositaryId;
	
	/** @ORM\Column(type="bigint") */
	protected $UserApplicantId;
	
	/** @ORM\Column(type="datetime") */
	protected $DateRequest;
	
	/** @ORM\Column(type="bigint") */
	protected $PieceId;
	
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