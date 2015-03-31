<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Search\Models\MainUser;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

/**
 * jsonController
 *
 * @author
 *
 * @version
 *
 */
class JsonController extends AbstractActionController {
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
		// TODO Auto-generated jsonController::indexAction() default action
		return new ViewModel ();
	}
	
	/**
	 * Liste les villes associé à un code postal.
	 * @return \Zend\View\Model\JsonModel
	 */
	public function townsAction() {
		$request=$this->getRequest();
		$pc=$request->getQuery('postalCode');
		$em=$this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		$query=$em->createQuery("select v.Name from Search\Models\Towns v where v.CP=?1 order by v.Name");
		$query->setParameter(1,$pc);
		$result=$query->getResult();
		return new JsonModel(array(
				'towns' => $result,
				'status' => 'OK'
		));
	}
	
	public function verifmailAction() {
		$request=$this->getRequest();
		$email=$request->getQuery('email');
		$auth=new AuthenticationService();
		$auth->setStorage(new SessionStorage('kmpv1'));
		if ($auth->hasIdentity()) {
			$userService=$this->getServiceLocator()->get('User\Service\Users');
			$mailConnected=$userService->findById($auth->getIdentity())->getEmail();
		}
		$em=$this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		$query=$em->createQuery("select count(u.id) from Search\Models\MainUser u where u.Email=?1");
		$query->setParameter(1,$email);
		$result=$query->getSingleScalarResult();
		// si on est connecté et que l'adresse saisie et la même, on fait rien
		if (isset($mailConnected) && ($result!=0)) {
			if ($email==$mailConnected) $result=0;
		}
		return new JsonModel(array('exist' => $result));
	}
}