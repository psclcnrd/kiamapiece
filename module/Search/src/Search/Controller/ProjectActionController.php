<?php

namespace Search\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Controller\UserAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter as LogAdapter;
use Zend\Log\Writer\Db as DbLog;
use Zend\Log\Logger;

abstract class ProjectActionController extends AbstractActionController {
	/**
	 * Service des logs
	 * @var unknown
	 */
	protected $logger;
	
	/**
	 * Service du traducteur
	 * @var unknown
	 */
	protected $translator;
	
	/**
	 * Service du gestionnaire detable des users
	 * @var unknown
	 */
	protected $usersService;
	
	/**
	 * Recherche le gestionnaire de log Zend\Logger
	 * @return Service des Logger
	 */
	protected function getLog() {
		if ($this->logger===null) {
			if (getenv("APPLICATION_MODE")!==false) {
				$dbConfig=array(
					'driver' => 'pdo',
					'dsn' => 'mysql:host=localhost;dbname=kiamapiece',
					'username'	=> 'root',
					'password' => 'g27un9TA'
				);
			} else {
				$dbConfig=array(
						'driver' => 'pdo',
						'dsn' => 'mysql:host=mysql51-117.perso;dbname=kiamapie_tmd',
						'username'	=> 'kiamapie_tmd',
						'password' => 'ZmhUkN4Ek8Q8'
				);
			}
			$mapping = array(
					'timestamp' => 'OperationDate',
					'priority'  => 'Priority',
					'message'   => 'Operation'
			);
			$db=new LogAdapter($dbConfig);
			$writer = new DbLog($db, 'logs',$mapping);
			$logger = new Logger();
			$logger->addWriter($writer);
			$this->logger=$logger;
		}
		return  $this->logger;
	}
	
	/**
	 * Récupère le 'service manager' du traducteur
	 */
	protected function getTranslator() {
		if ($this->translator===null) $this->translator=$this->getServiceLocator()->get('translator');
		return $this->translator;
	}
	
	protected function getUsersService() {
		if ($this->usersService==null) {
			$this->usersService=$this->getServiceLocator()->get('User\Service\Users');
		}
		return $this->usersService;
	}
	
	/**
	 * Construction du layout
	 * @param string $name Nom du module appelant le layout
	 */
	protected function buildLayout($name=null) {
		$auth=new AuthenticationService();
		$auth->setStorage(new SessionStorage("kmpv1"));
		if ($auth->hasIdentity()) {
			$usersService=$this->getUsersService();
			$user=$usersService->findById($auth->getIdentity());
			$uName=$user->getSurname()." ".$user->getName();
		} else $uName="";
	
		$layoutView=$this->layout();
		$layoutView->setVariable('buildType','normal');
		//$layoutView->setTemplate('layout/layout');
	
		$headerView=new ViewModel(array('auth' => $auth->hasIdentity(),'identity' => $uName));
		$headerView->setTemplate('content/header');
	
		$menuView=new ViewModel();
		$menuView->setTemplate('content/mainmenu');
	
		$footerView=new ViewModel();
		$footerView->setTemplate('content/footer');
	
		$layoutView->addChild($headerView,'appHeader');
		$layoutView->addChild($menuView,'appMenu');
		$layoutView->addChild($footerView,'appFooter');
	}
}

?>