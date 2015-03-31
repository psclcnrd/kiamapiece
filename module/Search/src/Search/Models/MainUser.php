<?php

/**
 * Table des Utilisateurs
 * @author CONRAD pascal
 * @version 1.0
 * @version 1.1 Suppression du champs MainAddress. Problème intialisation double.
 * @version 1.2 Ajout d'un champs de validation de l'utilisateur
 * @version 1.3 Ajout pseudo pour affichage
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
	
	/** @ORM\Column(type="string",length=20) */
	protected $Pseudo;
	
	/** @ORM\Column(type="string",length=80) */
	protected $Name;
	
	/** @ORM\Column(type="string",length=120) */
	protected $Surname;
	
	/** @ORM\Column(type="string",length=20) */
	protected $Phone1;
	
	/** @ORM\Column(type="string",length=20) */
	protected $Phone2;
	
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
	
	/**
	 * Utilisateur validé ?
	 * @ORM\Column(type="string",columnDefinition="ENUM('Y','N')")
	 */
	protected $Validated;
	
	/** @ORM\OneToMany(targetEntity="Addresses",mappedBy="UserId") */
	protected $Addresses;
	
	/**************************************************************/
	/* Définition des fonctions                                   */
	/**************************************************************/
	
	/**
	 * Constructeur de classe
	 */
	public function __construct() {
		$this->CreateDate=new \DateTime('now');
		$this->LastActivity=new \DateTime('now');
		$this->Note=1;
		$this->Revoked='N';
		$this->PrivateUser='Y';
		$this->Validated='N';
		$this->Addresses=new ArrayCollection();
	}
	
	/**
	 * Set $id value
	 * @param integer $id
	 * @return MainUser
	 */
	public function setId($id) {
	  $this->id=$id;
	  return $this;
	}
	 
	/**
	 * get $id value
	 * @return integer
	 */
	public function getId() {
	  return $this->id;
	}
	
	/**
	 * Set $Email value
	 * @param string $Email
	 * @return MainUser
	 */
	public function setEmail($Email) {
	  $this->Email=$Email;
	  return $this;
	}
	 
	/**
	 * get $Email value
	 * @return string
	 */
	public function getEmail() {
	  return $this->Email;
	}
	
	/**
	 * Set $Pseudo value
	 * @param string $Pseudo
	 * @return MainUser
	 */
	public function setPseudo($Pseudo) {
	  $this->Pseudo=$Pseudo;
	  return $this;
	}
	 
	/**
	 * get $Pseudo value
	 * @return string
	 */
	public function getPseudo() {
	  return $this->Pseudo;
	}
	
	/**
	 * Set $Addresses value
	 * @param array $Addresses
	 * @return MainUser
	 */
	public function setAddresses($Addresses) {
	  $this->Addresses=$Addresses;
	  return $this;
	}
	 
	/**
	 * get $Addresses value
	 * @return array
	 */
	public function getAddresses() {
	  return $this->Addresses;
	}
	  
	/**
	 * Set $Name value
	 * @param type $Name
	 * @return MainUser
	 */
	public function setName($Name) {
	  $this->Name=$Name;
	  return $this;
	}
	 
	/**
	 * get $Name value
	 * @return type
	 */
	public function getName() {
	  return $this->Name;
	}
	  
	/**
	 * Set $Surname value
	 * @param string $Surname
	 * @return MainUser
	 */
	public function setSurname($Surname) {
	  $this->Surname=$Surname;
	  return $this;
	}
	 
	/**
	 * get $Surname value
	 * @return string
	 */
	public function getSurname() {
	  return $this->Surname;
	}
	  
	/**
	 * Set $Phone1 value
	 * @param string $Phone1
	 * @return MainUser
	 */
	public function setPhone1($Phone1) {
	  $this->Phone1=$Phone1;
	  return $this;
	}
	 
	/**
	 * get $Phone1 value
	 * @return string
	 */
	public function getPhone1() {
	  return $this->Phone1;
	}
	  
	/**
	 * Set $Phone2 value
	 * @param string $Phone2
	 * @return MainUser
	 */
	public function setPhone2($Phone2) {
	  $this->Phone2=$Phone2;
	  return $this;
	}
	 
	/**
	 * get $Phone2 value
	 * @return string
	 */
	public function getPhone2() {
	  return $this->Phone2;
	}
	  
	/**
	 * Set $CreateDate value
	 * @param Datetime $CreateDate
	 * @return MainUser
	 */
	public function setCreateDate($CreateDate) {
	  $this->CreateDate=$CreateDate;
	  return $this;
	}
	 
	/**
	 * get $CreateDate value
	 * @return Datetime
	 */
	public function getCreateDate() {
	  return $this->CreateDate;
	}
	  
	/**
	 * Set $LastActivity value
	 * @param Datetime $LastActivity
	 * @return MainUser
	 */
	public function setLastActivity($LastActivity) {
	  $this->LastActivity=$LastActivity;
	  return $this;
	}
	 
	/**
	 * get $LastActivity value
	 * @return Datetime
	 */
	public function getLastActivity() {
	  return $this->LastActivity;
	}
	  
	/**
	 * Set $Note value
	 * @param integer $Note
	 * @return MainUser
	 */
	public function setNote($Note) {
	  $this->Note=$Note;
	  return $this;
	}
	
	/**
	 * get $Note value
	 * @return integer
	 */
	public function getNote() {
		return $this->Note;
	}
	
	/**
	 * Set $Revoked value
	 * @param string $Revoked
	 * @return MainUser
	 */
	public function setRevoked($Revoked) {
	  $this->Revoked=$Revoked;
	  return $this;
	}
	 
	/**
	 * get $Revoked value
	 * @return string
	 */
	public function getRevoked() {
	  return $this->Revoked;
	}
	  
	/**
	 * Set $RegionId value
	 * @param integer $RegionId
	 * @return MainUser
	 */
	public function setRegionId($RegionId) {
	  $this->RegionId=$RegionId;
	  return $this;
	}
	 
	/**
	 * get $RegionId value
	 * @return integer
	 */
	public function getRegionId() {
	  return $this->RegionId;
	}
	  
	/**
	 * Set $PrivateUser value
	 * @param string $PrivateUser
	 * @return MainUser
	 */
	public function setPrivateUser($PrivateUser) {
	  $this->PrivateUser=$PrivateUser;
	  return $this;
	}
	 
	/**
	 * get $PrivateUser value
	 * @return string
	 */
	public function getPrivateUser() {
	  return $this->PrivateUser;
	}
  
	/**
	 * Set $Password value
	 * @param string $Password
	 * @return MainUser
	 */
	public function setPassword($Password) {
	  $this->Password=$Password;
	  return $this;
	}
	 
	/**
	 * get $Password value
	 * @return string
	 */
	public function getPassword() {
	  return $this->Password;
	}
	  
	/**
	 * Set $Validated value
	 * @param string $Validated
	 * @return MainUser
	 */
	public function setValidated($Validated) {
	  $this->Validated=$Validated;
	  return $this;
	}
	 
	/**
	 * get $Validated value
	 * @return string
	 */
	public function getValidated() {
	  return $this->Validated;
	}
	  
	
	/**
	 * Convertie l'objet en tableau associatif
	 * @return array
	 */
	public function getArrayCopy() {
		$data=array();
		$data['id']=$this->id;
		$data['Email']=$this->Email;
		$data['Pseudo']=$this->Pseudo;
		$data['Name']=$this->Name;
		$data['Surname']=$this->Surname;
		$data['Phone1']=$this->Phone1;
		$data['Phone2']=$this->Phone2;
		$data['CreateDate']=$this->CreateDate;
		$data['LastActivity']=$this->LastActivity;
		$data['Note']=$this->Note;
		$data['Revoked']=$this->Revoked;
		$data['RegionId']=$this->RegionId;
		$data['PrivateUser']=$this->PrivateUser;
		$data['Password']=$this->Password;		
		$data['Validated']=$this->Validated;
		return $data;
	}
	
	/**
	 * Echange un tableau associatif avec les données de classe
	 * Note : les valeurs non affectés dans le tableau ne mettent pas à null les valeurs
	 *        le mot de passe est en clair, et sera donc transformer en MD5
	 * @param array $data
	 */
	public function exchangeArray(array $data) {
		if (isset($data['id'])) $this->id=$data['id'];
		if (isset($data['Email'])) $this->Email=$data['Email'];
		if (isset($data['Pseudo'])) $this->Pseudo=$data['Pseudo'];
		if (isset($data['Name'])) $this->Name=$data['Name'];
		if (isset($data['Surname'])) $this->Surname=$data['Surname'];
		if (isset($data['Phone1'])) $this->Phone1=$data['Phone1'];
		if (isset($data['Phone2'])) $this->Phone2=$data['Phone2'];
		if (isset($data['CreateDate'])) $this->CreateDate=$data['CreateDate'];
		if (isset($data['LastActivity'])) $this->LastActivity=$data['LastActivity'];
		if (isset($data['Note'])) $this->Note=$data['Note'];
		if (isset($data['Revoked'])) $this->Revoked=$data['Revoked'];
		if (isset($data['RegionId'])) $this->RegionId=$data['RegionId'];
		if (isset($data['PrivateUser'])) $this->PrivateUser=$data['PrivateUser'];
		if (isset($data['Password'])) $this->Password=md5($data['Password']);
		if (isset($data['Validated'])) $this->Validated=$data['Validated'];
	}

	/**
	 * Récupération et mis en place des filte de validation des champs pour le formulaire
	 * @return InputFilter
	 */
	public function getInputFilter() {
		if (!$this -> inputFilter) {
			$inputFilter = new InputFilter();
			$factory = new InputFactory();
	
	        // Vérification du nom et prénom
			$inputFilter->add($factory->createInput(array(
					'name' => 'Name',
					'required' => true,
					'filters' => array(
							            array('name' => 'StripTags'),
							            array('name' => 'StringTrim'),
			                          ),
					'validators' => array(
							            array(
							            		'name' => 'StringLength',
							            		'options' => array(
							            				            'encoding' => 'UTF-8',
							            				            'min' => 2,
							            				            'max' => 80,
							            		                  ),
							                 ),
							             ),
							            		)));
			$inputFilter->add($factory->createInput(array(
					'name' => 'Surname',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name' => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min' => 2,
											'max' => 120,
									),
							),
					),
			)));
			// Adresse mail
			$inputFilter->add($factory->createInput(array(
					'name' => 'Email',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name' => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min' => 2,
											'max' => 80,
									),
							),
							array(
									'name' => 'EmailAddress',
									'options' => array(
				                            'domain' => false
			                         )
							),
							array(
									'name' => 'NotEmpty',
									'options' => array(
											'message' => 'Ne peut peut être vide.'
									)
							)
					),
			)));
			// Pseudo
			$inputFilter->add($factory->createInput(array(
					'name' => 'Pseudo',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name' => 'NotEmpty',
									'options' => array(
											'message' => utf8_encode('Vous devez saisir un pseudo.')
									)
							)
					)
			)));			
			// Téléphone
			$inputFilter->add($factory->createInput(array(
					'name' => 'Phone1',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name' => 'NotEmpty',
									'options' => array(
											'message' => 'Saisissez au moins un numéro.'
									)
							)
					)
			)));			
			// second téléphone
			$inputFilter->add($factory->createInput(array(
					'name' => 'Phone2',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					)
			)));
			// Mot de passe
			$inputFilter->add($factory->createInput(array(
					'name' => 'Password',
					'required' => true,
					'validators' => array(
									array(
											'name' => 'StringLength',
											'options' => array(
													'encoding' => 'UTF-8',
													'min' => 5,
													'max' => 20,
													'message' => 'Le mot de passe doit contenir au moins 5 caractères, au plus 20'
											),
									),
									/*array(
											'name' => 'NotEmpty',
											'options' => array(
													'message' => 'Ne peut peut être vide.'
											)
									)*/
							)
			)));
			$inputFilter->add($factory->createInput(array(
					'name' => 'PostalCode',
					'required' => true,
					'validators' => array(
							array('name' => 'Digits','options' => array('message' => 'Uniquement des chiffres'))
					),
			)));
			$inputFilter->add($factory->createInput(array(
					'name' => 'Number',
					'required' => false,
					'validators' => array(
							array('name' => 'Digits','options' => array('message' => 'Uniquement des chiffres'))
					),
			)));
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
	
	/**
	 * Récupération et mis en place des filte de validation des champs pour le formulaire
	 * Réduit sans mot de passe
	 * @return InputFilter
	 */
	public function getInputFilterReduced() {
		if (!$this -> inputFilter) {
			$inputFilter = new InputFilter();
			$factory = new InputFactory();
	
			// Vérification du nom et prénom
			$inputFilter->add($factory->createInput(array(
					'name' => 'Name',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name' => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min' => 2,
											'max' => 80,
									),
							),
					),
			)));
			$inputFilter->add($factory->createInput(array(
					'name' => 'Surname',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name' => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min' => 2,
											'max' => 120,
									),
							),
					),
			)));
			// Adresse mail
			$inputFilter->add($factory->createInput(array(
					'name' => 'Email',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name' => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min' => 2,
											'max' => 80,
									),
							),
							array(
									'name' => 'EmailAddress',
									'options' => array(
											'domain' => false
									)
							),
							array(
									'name' => 'NotEmpty',
									'options' => array(
											'message' => 'Ne peut peut être vide.'
									)
							)
					),
			)));
			// Pseudo
			$inputFilter->add($factory->createInput(array(
					'name' => 'Pseudo',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name' => 'NotEmpty',
									'options' => array(
											'message' => utf8_encode('Vous devez saisir un pseudo.')
									)
							)
					)
			)));
			// Téléphone
			$inputFilter->add($factory->createInput(array(
					'name' => 'Phone1',
					'required' => true,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name' => 'NotEmpty',
									'options' => array(
											'message' => 'Saisissez au moins un numéro.'
									)
							)
					)
			)));
			// second téléphone
			$inputFilter->add($factory->createInput(array(
					'name' => 'Phone2',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					)
			)));
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