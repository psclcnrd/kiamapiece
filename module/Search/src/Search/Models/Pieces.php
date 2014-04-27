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
	
	/**
	 * Convertie l'objet en tableau associatif
	 * @return array
	 */
	public function getArrayCopy() {
		return get_object_vars($this);
	}
	
	/**
	 * Echange un tableau associatif avec les données de classe
	 * @param array $data
	 */
	public function exchangeArray(array $data) {
		$this->$id=(isset($data['id'])) ? $data['id'] : null;
	    $this->User=(isset($data['UserId'])) ? $data['UserId'] : null;
		$this->Address=(isset($data['UserId'])) ? $data['UserId'] : null;
		$this->Brand=(isset($data['BrandId'])) ? $data['BrandId'] : null;
	    $this->ApplianceType=(isset($data['ApplianceTypeId'])) ? $data['ApplianceTypeId'] : null;
		$this->PieceType=(isset($data['PieceTypeId'])) ? $data['PieceTypeId'] : null;
		$this->SendingMode=(isset($data['SendingModeId'])) ? $data['SendingModeId'] : null;
		$this->CreateDate=(isset($data['CreateDate'])) ? $data['CreateDate'] : null;
		$this->Status=(isset($data['StatusId'])) ? $data['StatusId'] : null;
		$this->Comments=(isset($data['Comments'])) ? $data['Comments'] : null;
	}
	/**
	 * Récupération et mis en place des filte de validation des champs pour le formulaire
	 * @return InputFilter
	 */
	public function getInputFilter() {
		if (!$this -> inputFilter) {
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


