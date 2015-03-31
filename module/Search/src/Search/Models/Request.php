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
	
	/**
	 *  @ORM\OneToOne(targetEntity="Pieces")
	 *  @ORM\JoinColumn(name="PieceId",referencedColumnName="Id")
	 */
	protected $Piece;
	
	/**
	 * Constructeur de classe
	 */
	public function __construct() {

	}

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
	 * Set $UserDepositaryId value
	 * @param integer $UserDepositaryId
	 * @return Request
	 */
	public function setUserDepositaryId($UserDepositaryId) {
	  $this->UserDepositaryId=$UserDepositaryId;
	  return $this;
	}
	 
	/**
	 * get $UserDepositaryId value
	 * @return integer
	 */
	public function getUserDepositaryId() {
	  return $this->UserDepositaryId;
	}
	  
	/**
	 * Set $UserApplicantId value
	 * @param integer $UserApplicantId
	 * @return Request
	 */
	public function setUserApplicantId($UserApplicantId) {
	  $this->UserApplicantId=$UserApplicantId;
	  return $this;
	}
	 
	/**
	 * get $UserApplicantId value
	 * @return integer
	 */
	public function getUserApplicantId() {
	  return $this->UserApplicantId;
	}
	
	/**
	 * Set $DateRequest value
	 * @param Datetime $DateRequest
	 * @return Request
	 */
	public function setDateRequest($DateRequest) {
	  $this->DateRequest=$DateRequest;
	  return $this;
	}
	 
	/**
	 * get $DateRequest value
	 * @return Datetime
	 */
	public function getDateRequest() {
	  return $this->DateRequest;
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
	 * Convertie l'objet en tableau associatif
	 * @return array
	 */
	public function getArrayCopy() {
		$data=array();
		$data['id']=$this->id;
		$data['UserDepositaryId']=$this->UserDepositaryId;
		$data['UserApplicantId']=$ths->UserApplicantId;
		$data['DateRequest']=$this->DateRequest;
		$data['Piece']=$this->Piece;
		return $data;
	}
	  
	/**
	 * Echange un tableau associatif avec les données de classe
	 * Note : les valeurs non affectés dans le tableau ne mettent pas à null les valeurs
	 * @param array $data
	 */
	public function exchangeArray(array $data) {
		if (isset($data['id'])) $this->id=$data['id'];
		if (isset($data['UserDepositaryId'])) $this->UserDepositaryId=$data['UserDepositaryId'];
		if (isset($data['UserApplicantId'])) $this->UserApplicantId=$data['UserApplicantId'];
		if (isset($data['DateRequest'])) $this->DateRequest=$data['DateRequest'];
		if (isset($data['Piece'])) $this->Piece=$data['Piece'];
	}
	  
}

?>