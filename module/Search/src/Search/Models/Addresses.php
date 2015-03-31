<?php

namespace Search\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Table des Adresses
 *
 * @ORM\Entity
 * @ORM\Table(name="Addresses")
 * @property bigint $id Identifiant
 * @property bigint $UserId Identifiant de l'utilisateur à qui appartient cette adresse
 * @property integer Number Numéro de rue
 * @property string Street Nom de la rue
 * @property string Complement Adresse complémentaire;
 * @property integer PostalCode Code postal
 * @property string Town Ville
 * @property integer Country Pays
 * @property enum MainAddress Adresse principale (Y/N)
 *
 * @author CONRAD Pascal
 */

class Addresses {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(name="Id",type="bigint")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/** @ORM\Column(type="string",length=100) */
	protected $AddressName;
	
	/**
     *  @ORM\ManyToOne(targetEntity="MainUser",inversedBy="Addresses")
     *  @ORM\JoinColumn(name="UserId", referencedColumnName="Id")
	 */
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
	protected $Town;
	
	/** @ORM\Column(type="string",length=100) */
	protected $Country;
	
	/** @ORM\Column(type="string",columnDefinition="ENUM('Y','N')") */
	protected $MainAddress;
	
	/** @ORM\Column(type="integer") */
	protected $RegionId;
	
	/**
	 * Constructeur de classe
	 */
	public function __construct() {
	  $this->Country=1;
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

	/**
	 * Convertie l'objet en tableau associatif
	 * @return array
	 */
	public function getArrayCopy() {
       	$data=array();
		$data['id']=$this->id;
		$data['AddressName']=$this->AddressName;
		$data['UserId']=$this->UserId;
		$data['Number']=$this->Number;
		$data['Street']=$this->Street;
		$data['Complement']=$this->Complement;
		$data['PostalCode']=$this->PostalCode;
		$data['Town']=$this->Town;
		$data['Country']=$this->Country;
		$data['MainAddress']=$this->MainAddress;       
		$data['RegionId']=$this->RegionId;
       	return $data;
	}
	
	/**
	 * Echange un tableau associatif avec les données de classe
	 * @param array $data
	 */
	public function exchangeArray(array $data) {
		if (isset($data['id'])) $this->id=$data['id'];
		if (isset($data['AddressName'])) $this->AddressName=$data['AddressName'];
		if (isset($data['UserId'])) $this->UserId=$data['UserId'];
		if (isset($data['Number'])) $this->Number=$data['Number'];
		if (isset($data['Street'])) $this->Street=$data['Street'];
		if (isset($data['Complement'])) $this->Complement=$data['Complement'];
		if (isset($data['PostalCode'])) $this->PostalCode=$data['PostalCode'];
		if (isset($data['Town'])) $this->Town=$data['Town'];
		if (isset($data['Country'])) $this->Country=$data['Country'];
		if (isset($data['MainAddress'])) $this->MainAddress=$data['MainAddress'];
		if (isset($data['RegionId'])) $this->RegionId=$data['RegionId'];
	}
}
