<?php

/**
 * Table des Utilisateurs
 * @author CONRAD pascal
 * @version 1.0
 *
 */

namespace Search\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Table des utilisateurs
 * 
 * @ORM\Entity
 * @ORM\Table(name="MainUser")
 * 
 * @author CONRAD Pascal
 */

class MainUser {
	/**
	 * @ORM\Id 
	 * @ORM\Column(name="Id",type="bigint")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/** @ORM\Column(type="String",length=200) */
	protected $Email;
	
	/** @ORM\Column(type="String",length=80) */
	protected $name;
	
	/** @ORM\Column(type="String",length=120) */
	protected $Surname;
	
	/** @ORM\Column(type="String",length=20) */
	protected $Phone1;
	
	/** @ORM\Column(type="String",length=20) */
	protected $Phone2;
	
	/** @ORM\Column(type="bigint") */
	protected $MainAddress;
	
	/** @ORM\Column(type="datetime") */
	protected $CreateDate;
	
	/** @ORM\Column(type="datetime") */
	protected $LastActivity;
	
	/** @ORM\Column(type="integer") */
	protected $Note;
	
	/** @ORM\Column(type="integer") */
	protected $revoked;
	
	/** @ORM\Column(type="integer") */
	protected $RegionId;

	/**
	 * Pour plus tard, dans le cas d'admission de professionnel 
	 * @ORM\Column(type="varchar",columnDefinition="ENUM('Y','N')") 
	 */
	protected $PrivateUser;
	
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