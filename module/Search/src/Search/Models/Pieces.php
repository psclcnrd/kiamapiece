<?php
/**
 * Classe de gestion des pièces
 *
 * @author CONRAD pascal
 * @version 1.0 - 10/04/2014
 *
 */

namespace Search\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Table des Pièce
 *
 * @ORM\Entity
 * @ORM\Table(name="Pieces")
 *
 * @author CONRAD Pascal
 */

class Pieces {
	/**
	 * @ORM\Id
	 * @ORM\Column(name="Id",type="bigint")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

    /** @ORM\Column(type="bigint") */
	protected $UserId;
	
	/** @ORM\Column(type="bigint") */
	protected $AddressId;

	/** @ORM\Column(type="bigint") */
	protected $BandId;

	/** @ORM\Column(type="bigint") */
	protected $ApplianceTypeId;
	
	/** @ORM\Column(type="bigint") */
	protected $PieceTypeId;
	
	/** @ORM\Column(type="bigint") */
	protected $SendingModeId;
	
	/** @ORM\Column(type="datetime") */
	protected $CreateDate;
	
	/** @ORM\Column(type="bigint") */
	protected $StatusId;
	
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
}

?>
