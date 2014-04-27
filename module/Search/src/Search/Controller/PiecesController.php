<?php

/**
 * Controller pour la gestion du module de recherche
 * 
 * @author CONRAD Pascal
 * @version 1.0 - 11/04/2014
 *
 */

namespace Search\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Search\Models\Pieces;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use DoctrineORMModule\Form\Element\DoctrineEntity;
use Zend\Log\Logger;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;
use Zend\Session\Config\StandardConfig;
use Zend\Session\SessionManager;

class PiecesController extends AbstractActionController {

	/**
	 * Entity Manager de doctrine
	 * @var unknown
	 */
	private $em;
	private $log;
	
	
	/**
	 * Recherche le manager de la base de données, Doctrine en l'occurence
	 * @return DoctrineEntityManager
	 */
	public function getEntityManager() {
		if ($this->em===null) {
			$this->em=$this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}
		//$this->getLog()->info("getEntityManager :".(($this->em==null) ? 'vide' : 'complet'));
		return $this->em;
	}
	
	/**
	 * Recherche le gestionnaire de log Zend\Logger
	 * @return Service des Logger
	 */
	private function getLog() {
		if ($this->log===null) {
			$this->log=$this->getServiceLocator()->get('Zend\Log');
		}
		return  $this->log;
	}
	
	private function buildLayout() {
		$em=$this->getEntityManager();
		// Composition de la requête de sélection de la région
	
		$layoutView=$this->layout();
		//$layout->setTemplate('layout/layout');
		
		$headerView=new ViewModel();
		$headerView->setTemplate('content/header');
		
		$menuView=new ViewModel();
		$menuView->setTemplate('content/mainmenu');
		
		$footerView=new ViewModel();
		$footerView->setTemplate('content/footer');
		
		$layoutView->addChild($headerView,'appHeader');
		$layoutView->addChild($menuView,'appMenu');
		$layoutView->addChild($footerView,'appFooter');		
	}
	
	/**
	 * Appelé lors de l'appel à l'URL /search
	 * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
	 */
	public function indexAction() {
		//$this->getLog()->info("Entre dans indexAction");
		$em=$this->getEntityManager();
		//$resultSet = $em->getRepository('Search\Models\Pieces')->findAll();
		
		// Composition de la requête nécessaire à l'affichage de la liste des pièces
		$qb=$em->createQueryBuilder();
		$qb->select(array('p','b','a','t'))
		   ->from('Search\Models\Pieces','p')
		   ->leftJoin('p.User','u')
		   ->leftJoin('p.Brand','b')
		   ->leftJoin('p.ApplianceType','a')
		   ->leftJoin('p.PieceType','t');
		   //->setFirstResult(1)
		   //->setMaxResults(10)
		   //->orderBy('p.CreateDate','DESC');
		$query=$qb->getQuery();
		$resultSet=$query->getResult();

		$qb=$em->createQueryBuilder();
		$qb->select('r')->from('Search\Models\Region','r')->orderBy("r.Description");
		$query=$qb->getQuery();
		$reg=$query->getArrayResult();
		// Composition de la requête de sélection de la marque
		$qb=$em->createQueryBuilder();
		$qb->select('b')->from('Search\Models\Brand','b')->orderBy("b.Description");
		$query=$qb->getQuery();
		$brand=$query->getArrayResult();
		// Composition de la requête de sélection du type d'appareil
		$qb=$em->createQueryBuilder();
		$qb->select('a')->from('Search\Models\ApplianceType','a')->orderBy("a.Description");
		$query=$qb->getQuery();
		$apt=$query->getArrayResult();
		// Composition de la requête du type de pièce
		$qb=$em->createQueryBuilder();
		$qb->select('t')->from('Search\Models\PieceType','t')->orderBy("t.Description");
		$query=$qb->getQuery();
		$pct=$query->getArrayResult();
		
        $this->buildLayout();

		//$view=new ViewModel(array('pieces',$resultSet));
		//$view->setTemplate('search/pieces/index');
		
  	    //$this->getLog()->info("Apres requete");
        return new ViewModel(array(
            'pieces' => $resultSet,
        	'reg' => $reg,
        	'brand' => $brand,
        	'apt' => $apt,
        	'pct' => $pct,
        	'needSearchBar' => true
        ));
	}
	
	public function listAction() {
		$resultSet = $this->getEntityManager()->getRepository('Search\Models\Pieces')->findAll();
 
		$layoutView=$this->layout();
		$headerView=new ViewModel();
		$headerView->setTemplate('content/header');
		$layoutView->addChild($headerView,'appHeader');
        return new ViewModel(array(
            'pieces' => $resultSet,
        ));
	}
	
	/**
	 * Visualiser la fiche d'une piéce
	 * @return ViewModel
	 */
	public function viewAction() {
		// On récupère l'ID à visualiser
		$searchRegionId=$this->params()->fromRoute('searchRegionId',null);
		$searchBrandId=$this->params()->fromRoute('searchBrandId',null);
		$searchAptId=$this->params()->fromRoute('searchAptId',null);
		$searchPctId=$this->params()->fromRoute('searchPctId',null);
		
		$qb=$this->getEntityManager()->createQueryBuilder();
		// On récupère les données de la fiche
		$qb->select(array('a','b','c','d','e','f'))
		->from('Search\Models\Pieces','a')
		->leftJoin('a.User','b')
		->leftJoin('a.Brand','c')
		->leftJoin('a.ApplianceType','d')
		->leftJoin('a.PieceType','e')
		->leftJoin('a.Address','f');
		if ($searchRegionId!=0) $qb->addWhere("b.RegionId=$searchRegionId");
		$query=$qb->getQuery();
		$resultSet=$query->getResult();
		$this->buildLayout();
        return new JsonModel(array(
            	'pieces' => $resultSet,
        		'th_marque' => $this->translate('th_marque','search'),
        		'th_appareil'=> $this->translate('th_appareil','search'),
        		'th_piece' => $this->translate('th_piece','search')
        ));
	}	
	
	
	public function loginAction() {
		$request=$this->getRequest();
		$id=$request->getQuery('log_id');
		$pw=$request->getQuery('log_pwd');
		
		$qb=$this->getEntityManager()->createQueryBuilder();
		$qb->select('u')->from('Search\Models\MainUser','u')->where("u.Email = ?1")->andWhere('u.Password = ?2')->setParameters(array(1 => $id, 2=> md5($pw)));
		$query=$qb->getQuery();
		//$this->getLog()->info("Apres requete".$qb->getQuery());
		$result=$query->getSingleResult();
		if ($result!=null) {
			$stdConf=new StandardConfig();
			$stdConf->setOptions(array(
				'cookie_lifetime' => 1800,
				'remember_me_seconds' => 1800,
				'name' => 'kmp'
			));
			$sessManager=new SessionManager($stdConf);
			$sessions=new Container('kmp');
			$sessions->setDefaultManager($sessManager);
			$json=array("status" => "OK","Name" => $result->Name,"Surname" => $result->Surname,"user" => $result);
			$sessions->OffsetSet('userConnected',$result->id);
		} else $json=array("status" => "BAD");
		return new JsonModel($json);
	}
}
