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
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Table des utilisateurs
 * 
 * @ORM\Entity
 * @ORM\Table(name="MainUser")
 * 
 * @author CONRAD Pascal
 */

class MainUser implements InputFilterAwareInterface {
	
	protected $inputFilter;
	
	/**
	 * @ORM\Id 
	 * @ORM\Column(name="Id",type="bigint")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/** @ORM\Column(type="string",length=200) */
	protected $Email;
	
	/** @ORM\Column(type="string",length=80) */
	protected $Name;
	
	/** @ORM\Column(type="string",length=120) */
	protected $Surname;
	
	/** @ORM\Column(type="string",length=20) */
	protected $Phone1;
	
	/** @ORM\Column(type="string",length=20) */
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
	protected $Revoked;
	
	/** @ORM\Column(type="integer") */
	protected $RegionId;

	/**
	 * Pour plus tard, dans le cas d'admission de professionnel 
	 * @ORM\Column(type="string",columnDefinition="ENUM('Y','N')") 
	 */
	protected $PrivateUser;
	
	/** @ORM\Column(type="string",length=32) */
	protected $Password;
	
	/**************************************************************/
	/* Définition des fonctions                                   */
	/**************************************************************/
	
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
		$this->Email=(isset($data['Email'])) ? $data['Email'] : null;
		$this->Name=(isset($data['Name'])) ? $data['Name'] : null;
		$this->Surname=(isset($data['Surname'])) ? $data['Surname'] : null;
		$this->Phone1=(isset($data['Phone1'])) ? $data['Phone1'] : null;
		$this->Phone2=(isset($data['Phone2'])) ? $data['Phone2'] : null;
		$this->MainAddress=(isset($data['MainAddress'])) ? $data['MainAddress'] : null;
		$this->CreateDate=(isset($data['CreateDate'])) ? $data['CreateDate'] : null;
		$this->LastActivity=(isset($data['LastActivity'])) ? $data['LastActivity'] : null;
		$this->Note=(isset($data['Note'])) ? $data['Note'] : null;
		$this->Revoked=(isset($data['Revoked'])) ? $data['Revoked'] : null;
		$this->RegionId=(isset($data['RegionId'])) ? $data['RegionId'] : null;
		$this->PrivateUser=(isset($data['PrivateUser'])) ? $data['PrivateUser'] : null;
		$this->Password=(isset($data['Password'])) ? $data['Password'] : null;
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
	        // Vérification du nom et prénom
			$inputFilter->add($factory->createInput(array('name' => 'Name', 'required' => true, 'filters' => array( array('name' => 'StripTags'), array('name' => 'StringTrim'), ), 'validators' => array( array('name' => 'StringLength', 'options' => array('encoding' => 'UTF-8', 'min' => 2, 'max' => 80, ), ), ), )));
			$inputFilter->add($factory->createInput(array('name' => 'Surname', 'required' => true, 'filters' => array( array('name' => 'StripTags'), array('name' => 'StringTrim'), ), 'validators' => array( array('name' => 'StringLength', 'options' => array('encoding' => 'UTF-8', 'min' => 3, 'max' => 120, ), ), ), )));
	
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
	
	/**
	 * Initialise les filtes, mais ceux-ci sont déjà fait dans la classe ! donc arrêt !
	 * @param InputFilterInterface $inputFilter
	 * @throws \Exception
	 */
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception("Les filtres sont définis directement dans la classe");
	}
	
}

?>