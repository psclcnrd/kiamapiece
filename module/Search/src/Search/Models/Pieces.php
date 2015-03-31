<?php
/**
 * Classe de gestion des pièces
 *
 * @author CONRAD pascal
 * @version 1.0 - 10/04/2014
 *
 */

namespace Search\Models;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Table des Pièces
 *
 * @ORM\Entity
 * @ORM\Table(name="Pieces")
 *
 * @author CONRAD Pascal
 */

class Pieces implements InputFilterAwareInterface {
	/**
	 * @ORM\Id
	 * @ORM\Column(name="Id",type="bigint")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/** 
	 *  @ORM\OneToOne(targetEntity="MainUser")
	 *  @ORM\JoinColumn(name="UserId",referencedColumnName="Id")
	 */
	protected $User;
	
	/** 
	 *  @ORM\OneToOne(targetEntity="Addresses")
	 *  @ORM\JoinColumn(name="AddressId",referencedColumnName="Id")
	 */
	protected $Address;

	/** 
	 *  @ORM\OneToOne(targetEntity="Brand")
	 *  @ORM\JoinColumn(name="BrandId",referencedColumnName="Id")
	 */
	protected $Brand;

	/** 
	 *  @ORM\OneToOne(targetEntity="ApplianceType")
	 *  @ORM\JoinColumn(name="ApplianceTypeId",referencedColumnName="Id")
	 */
	protected $ApplianceType;
	
	/** 
	 *  @ORM\OneToOne(targetEntity="PieceType")
	 *  @ORM\JoinColumn(name="PieceTypeId",referencedColumnName="Id")
	 */
	protected $PieceType;
	
	/** 
	 *  @ORM\OneToOne(targetEntity="SendingMode")
	 *  @ORM\JoinColumn(name="SendingModeId",referencedColumnName="Id")
	 */
	protected $SendingMode;
	
	/** @ORM\Column(type="datetime") */
	protected $CreateDate;
	
	/** 
	 *  @ORM\OneToOne(targetEntity="Status")
	 *  @ORM\JoinColumn(name="StatusId",referencedColumnName="Id")
	 */
	protected $Status;
	
	/** @ORM\Column(type="text") */
	protected $Comments;
	
	/**
	 * content les filtes de validation
	 * @var unknown
	 */
	private $inputFilter;
	
	/**
	* @param integer $id
	* @return Pieces
	*/
	public function setId($id)
	{
	    $this->id = $id;
	    return $this;
	}
	 
	/**
	* @return integer
	*/
	public function getId()
	{
	    return $this->id;
	}
	
	/**
	 * Set $User value
	 * @param integer
	 * @return class
	 */
	 public function setUser($UserId) {
	   $this->User=$UserId;
	   return $this;
	 }
	 
	 /**
	  * get $User value
	  * @return integer
	  */
	  public function getUser() {
	    return $this->User;
	  }
	  
	/**
	 * Set Brand value
	 * @param integer $Brand
	 * @return Pieces
	 */
	 public function setBrand($Brand) {
	   $this->Brand=$Brand;
	   return $this;
	 }
	 
	 /**
	  * get Brand value
	  * @return integer
	  */
	  public function getBrand() {
	    return $this->Brand;
	  }
	  
	/**
	 * Set Address value
	 * @param integer $Address
	 * @return Pieces
	 */
	public function setAddress($Address) {
	  $this->Address=$Address;
	  return $this;
	}
	 
	/**
	 * get Address value
	 * @return integer
	 */
	public function getAddress() {
	  return $this->Address;
	}

	/**
	 * Set $ApplianceType value
	 * @param integer $ApplianceType
	 * @return Pieces
	 */
	public function setApplianceType($ApplianceType) {
	  $this->ApplianceType=$ApplianceType;
	  return $this;
	}
	 
	/**
	 * get $ApplianceType value
	 * @return integer
	 */
	public function getApplianceType() {
	  return $this->ApplianceType;
	}
	
	/**
	 * Set $PieceType value
	 * @param integer $PieceType
	 * @return Pieces
	 */
	public function setPieceType($PieceType) {
	  $this->PieceType=$PieceType;
	  return $this;
	}
	 
	/**
	 * get $PieceType value
	 * @return integer
	 */
	public function getPieceType() {
	  return $this->PieceType;
	}
	  
	/**
	 * Set $SendingMode value
	 * @param integer $SendingMode
	 * @return Pieces
	 */
	public function setSendingMode($SendingMode) {
	  $this->SendingMode=$SendingMode;
	  return $this;
	}
	 
	/**
	 * get $SendingMode value
	 * @return integer
	 */
	public function getSendingMode() {
	  return $this->SendingMode;
	}
	  
	/**
	 * Set $CreateDate value
	 * @param DateTime $CreateDate
	 * @return Pieces
	 */
	public function setCreateDate($CreateDate) {
	  $this->CreateDate=$CreateDate;
	  return $this;
	}
	 
	/**
	 * get $CreateDate value
	 * @return DateTime
	 */
	public function getCreateDate() {
	  return $this->CreateDate;
	}
	  
	/**
	 * Set $Status value
	 * @param integer $Status
	 * @return Pieces
	 */
	public function setStatus($Status) {
	  $this->Status=$Status;
	  return $this;
	}
	 
	/**
	 * get $Status value
	 * @return integer
	 */
	public function getStatus() {
	  return $this->Status;
	}
	  
	/**
	 * Set $Comments value
	 * @param string $Comments
	 * @return Pieces
	 */
	public function setComments($Comments) {
	  $this->Comments=$Comments;
	  return $this;
	}
	 
	/**
	 * get $Comments value
	 * @return string
	 */
	public function getComments() {
	  return $this->Comments;
	}
	  
	  
	/**
	 * Convertie l'objet en tableau associatif
	 * @return array
	 */
	public function getArrayCopy() {
		$data=array();
		$data["id"]=$this->id;
		$data["User"]=$this->User;
		$data["Address"]=$this->Address;
		$data["Brand"]=$this->Brand;
		$data["ApplianceType"]=$this->ApplianceType;
		$data["PieceType"]=$this->PieceType;
		$data["SendingMode"]=$this->SendingMode;
		$data["CreateDate"]=$this->CreateDate;
		$data["Status"]=$this->Status;
		$data["Comments"]=$this->Comments;
		return $data;
	}
	
	/**
	 * Echange un tableau associatif avec les données de classe
	 * Note : pas de mise à zéro des valeurs null dans le tableau source
	 * @param array $data
	 */
	public function exchangeArray(array $data) {
		if (isset($data['id'])) $this->id=$data['id'];
	    if (isset($data['User'])) $this->User=$data['User'];
		if (isset($data['Address'])) $this->Address=$data['Address'];
		if (isset($data['Brand'])) $this->Brand=$data['Brand'];
	    if (isset($data['ApplianceType'])) $this->ApplianceType=$data['ApplianceType'];
		if (isset($data['PieceType'])) $this->PieceType=$data['PieceType'];
		if (isset($data['SendingMode'])) $this->SendingMode=$data['SendingMode'];
		if (isset($data['CreateDate'])) $this->CreateDate=$data['CreateDate'];
		if (isset($data['Status'])) $this->Status=$data['Status'];
		if (isset($data['Comments'])) $this->Comments=$data['Comments'];
	}
	/**
	 * Récupération et mis en place des filte de validation des champs pour le formulaire
	 * @return InputFilter
	 */
	public function getInputFilter() {
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory = new InputFactory();
	
			//Vérifie que l'id est de type int
			$inputFilter->add($factory->createInput(array('name' => 'id', 'required' => true, 'filters' => array( array('name' => 'Int'), ), )));

			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
	
	/**
	 * Initialise les filtres, mais ceux-ci sont déjà fait dans la classe ! donc arrêt !
	 * @param InputFilterInterface $inputFilter
	 * @throws \Exception
	 */
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception("Les filtres sont définis directement dans la classe");
	}	
}


