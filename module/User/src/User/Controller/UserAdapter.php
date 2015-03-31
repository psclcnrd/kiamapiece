<?php

/**
 * Adaptateur pour une authentification
 *   
 * @author CONRAD pascal
 * @version 1.0 07/05/2014
 */

namespace User\Controller;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Doctrine\ORM\EntityManager;
use Doctrine;

class UserAdapter implements AdapterInterface {

	private $username;
	private $password;
	private $em;
	/**
	 * Constructeur de la classe
	 * @param string $username Identifiant de l'utilisateur (adresse mail)
	 * @param string $password Mot de passe au format md5
	 * @param EntityManager $em Entity Manager de Doctrine
	 */
	public function __construct($username,$password,EntityManager $em) {
		$this->username=$username;
		$this->password=$password;
		$this->em=$em;
	}
	
	/**
	 * Procédure principale d'authentification
	 * @todo Etendre le code de résultat en testant directement le champs Email dans la requeête, et le password dans le résultat de la requête
	 * @see \Zend\Authentication\Adapter\AdapterInterface::authenticate()
	 */
	public function authenticate() {
		$messages=array();
		$identity="";
		if ($this->em!==null) {
			$query=$this->em->createQuery("select u.id,u.Name,u.Surname from Search\Models\MainUser u where u.Email= ?1 and u.Password= ?2 and u.Revoked='N' and u.Validated='Y'");
			$query->setParameters(array( 1 => $this->username,2 => md5($this->password)));
			$r=$query->getResult();
			//error_log(print_r($r,true));
			if (count($r)==0) {
				$code=Result::FAILURE_CREDENTIAL_INVALID;
				$message[]="Echec d'authentification.";
			} else {
				$code=Result::SUCCESS;
				$message[]="Authentification correcte.";
				$identity=$r[0]["id"];
			}
		} else {
			$code=Result::FAILURE;
			$message[]="No entity manager !";
			throw new Exception('EntityManager not present !');
		}
		return new Result($code,$identity,$messages);
	}
}