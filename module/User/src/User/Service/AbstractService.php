<?php

namespace User\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

abstract class AbstractService {
	
	/**
	 * Entity Manager od Doctrine
	 * @var Doctrine\ORM\EntityManager
	 */
	private $em;
	
	/**
	 * Repository of model class
	 * @var Doctrine\ORM\EntityRepository
	 */
	private $rep;
	
	/**
	 * Constructor of the class
	 * 
	 * @param Doctrine\ORM\EntityManager $em
	 * @param Doctrine\ORM\EntityRepository $rep
	 */
	function __construct(\Doctrine\ORM\EntityManager $em,\Doctrine\ORM\EntityRepository $rep) {
		$this->em=$em;
		$this->rep=$rep;
	}
	
	/**
	 * return the entity manager of doctrine
	 * 
	 * @return Doctrine\ORM\EntityManager
	 */
	public function getEm() {
		return $this->em;
	}
	
	/**
	 * return the repository of the model class
	 * 
	 * @return Doctrine\ORM\EntityRepository
	 */
	public function getRep() {
		return $this->rep;
	}
}

?>