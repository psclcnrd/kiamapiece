<?php

/**
 * Classe de gestion des messages
 *
 * @author CONRAD pascal
 * @version 1.0 - 03/01/2015
 *
 */

namespace Search\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Table des Requêtes
 *
 * @ORM\Entity
 * @ORM\Table(name="Messages")
 *
 * @author CONRAD Pascal
 */

class Messages {
	/**
	 * @ORM\Id
	 * @ORM\Column(name="Id",type="bigint")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 *  @ORM\OneToOne(targetEntity="MainUser")
	 *  @ORM\JoinColumn(name="UserFromId",referencedColumnName="Id")
	 */
	protected $UserFrom;
	
	/**
	 *  @ORM\OneToOne(targetEntity="MainUser")
	 *  @ORM\JoinColumn(name="UserToId",referencedColumnName="Id")
	 */
	protected $UserTo;
	
	/**
	 *  @ORM\OneToOne(targetEntity="Pieces")
	 *  @ORM\JoinColumn(name="PieceId",referencedColumnName="Id")
	 */
	protected $Piece;
	
	/** @ORM\Column(type="datetime") */
	protected $CreateDate;
	
	/** @ORM\Column(type="text") */
	protected $Message;
	
	/**
	 * Message lu ?
	 * @ORM\Column(type="string",columnDefinition="ENUM('Y','N')")
	 */
	protected $MessageSee;
	
	/**
	 * Boite d'origine du message
	 * @ORM\Column(type="string",length=80)
	 */
	protected $MessageBox;
	
	/**
	 * Set $id value
	 * @param integer $id
	 * @return Request
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
	 * Set $UserFrom value
	 * @param integer $UserFrom
	 * @return Request
	 */
	public function setUserFrom($UserFrom) {
	  $this->UserFrom=$UserFrom;
	  return $this;
	}
	 
	/**
	 * get $UserDepositary value
	 * @return integer
	 */
	public function getUserFrom() {
	  return $this->UserFrom;
	}
	  
	/**
	 * Set $UserTo value
	 * @param integer $UserTo
	 * @return Request
	 */
	public function setUserTo($UserTo) {
	  $this->UserTo=$UserTo;
	  return $this;
	}
	 
	/**
	 * get $UserApplicant value
	 * @return integer or Search/Users/MainUser
	 */
	public function getUserTo() {
	  return $this->UserTo;
	}
	
	/**
	 * Set $Piece value
	 * @param integer $Piece
	 * @return Request
	 */
	public function setPiece($Piece) {
	  $this->Piece=$Piece;
	  return $this;
	}
	 
	/**
	 * get $PieceId value
	 * @return integer
	 */
	public function getPiece() {
	  return $this->Piece;
	}
	
	/**
	 * Set $CreateDate value
	 * @param Datetime $CreateDate
	 * @return Messages
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
	 * Set $Message value
	 * @param string $Message
	 * @return Messages
	 */
	public function setMessage($Message) {
	  $this->Message=$Message;
	  return $this;
	}
	 
	/**
	 * get $Message value
	 * @return string
	 */
	public function getMessage() {
	  return $this->Message;
	}
	  
	/**
	 * Set $MessageSee value
	 * @param string $MessageSee
	 * @return Messages
	 */
	public function setMessageSee($MessageSee) {
	  $this->MessageSee=$MessageSee;
	  return $this;
	}
	 
	/**
	 * get $MessageSee value
	 * @return string
	 */
	public function getMessageSee() {
	  return $this->MessageSee;
	}
	
	/**
	 * Set $MessageBox value
	 * @param string $MessageBox
	 * @return Messages
	 */
	public function setMessageBox($MessageBox) {
	  $this->MessageBox=$MessageBox;
	  return $this;
	}
	 
	/**
	 * get $MessageBox value
	 * @return string
	 */
	public function getMessageBox() {
	  return $this->MessageBox;
	}
	  
	
	/**
	 * Convertie l'objet en tableau associatif
	 * @return array
	 */
	public function getArrayCopy() {
		$data=array();
		$data['id']=$this->id;
		$data['UserFrom']=$this->UserFrom;
		$data['UserTo']=$ths->UserTo;
		$data['Piece']=$this->Piece;
		$data['CreateDate']=$this->CreateDate;
		$data['Message']=$this->Message;
		$data['MessageBox']=$this->MessageBox;
		$data['MessageSee']=$this->MessageSee;
		return $data;
	}
	  
	/**
	 * Echange un tableau associatif avec les données de classe
	 * Note : les valeurs non affectés dans le tableau ne mettent pas à null les valeurs
	 * @param array $data
	 */
	public function exchangeArray(array $data) {
		if (isset($data['id'])) $this->id=$data['id'];
		if (isset($data['UserFrom'])) $this->UserFrom=$data['UserFrom'];
		if (isset($data['UserTo'])) $this->UserTo=$data['UserTo'];
		if (isset($data['Piece'])) $this->Piece=$data['Piece'];
		if (isset($data['CreateDate'])) $this->CreateDate=$data['CreateDate'];
		if (isset($data['Message'])) $this->Message=$data['Message'];
		if (isset($data['MessageBox'])) $this->MessageBox=$data['MessageBox'];
		if (isset($data['MessageSee'])) $this->MessageSee=$data['MessageSee'];
	}
	  
}

?>