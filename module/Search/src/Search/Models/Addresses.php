<?php

namespace Search\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Table des Adresses
 *
 * @ORM\Entity
 * @ORM\Table(name="Addresses")
 *
 * @author CONRAD Pascal
 */

class Addresses {
	/**
	 * @ORM\ManyToOne(targetEntity="MainUser")
	 * @ORM\joinColumn(name="UserId", referencedColumnName="Id")
	 */
	
	/**
	 * @ORM\Id
	 * @ORM\Column(name="Id",type="bigint")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/** @ORM\Column(type="bigint") */
	protected  $UserId;
	
	/** @ORM\Column(type="integer") */
	protected $Number;
	
	/** @ORM\Column(type="string",length=120) */
	protected $Street;
	
	/** @ORM\Column(type="string",length=100) */
	protected $Complement;
	
	/** @ORM\Column(type="integer") */
	protected $PostalCode;
	
	/** @ORM\Column(type="string",length=100) */
	protected $Country;
	
	/** @ORM\Column(type="string",columnDefinition="ENUM('Y','N')") */
	protected $MainAddress;
	
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