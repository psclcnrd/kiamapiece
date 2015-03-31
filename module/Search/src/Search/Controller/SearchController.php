<?php

/**
 * Controller pour la gestion du module de recherche
 * 
 * @author CONRAD Pascal
 * @version 1.0 - 11/04/2014
 *
 */

namespace Search\Controller;

use \DateTime;
use Search\Controller\ProjectActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\FormInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use DoctrineORMModule\Form\Element\DoctrineEntity;
use Zend\Log\Logger;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;
use Zend\Session\Config\StandardConfig;
use Zend\Session\SessionManager;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Authentication\Storage\Session as SessionStorage;
use Search\Models\Pieces;
use Search\Form\PiecesForm;

class SearchController extends ProjectActionController {

	/**
	 * Entity Manager de doctrine
	 * @var unknown
	 */
	private $em;
	
	/**
	 * Page active d'affichage de la liste de pièces
	 * @var integer
	 */
	private $activePage;
	
	/**
	 * Container des données de sessions
	 * @var Zend\Session\Container
	 */
	private $container;
	
	/**
	 * Stockage des critères de recherce
	 * @var unknown
	 */
	private $criteria=array();
	
	/**
	 * Recherche le manager de la base de données, Doctrine en l'occurence
	 * @return DoctrineEntityManager
	 */
	private function getEntityManager() {
		if ($this->em===null) {
			$this->em=$this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}
		//$this->getLog()->info("getEntityManager :".(($this->em==null) ? 'vide' : 'complet'));
		return $this->em;
	}
	
	/**
	 * Sauvegarde les paramètres de session
	 */
	private function SetSession($searchType=null) {
		$container=new Container('session_kmpv1');
		$container->activePage=$this->activePage;
		if ($searchType!=null) $container->activeSearch=$searchType;
		if (($searchType!=null) && ($searchType=='criteria')) $container->criteria=$this->criteria;
		$this->container=$container;
	}
	
	/**
	 * Utiliser pour la navigaion et la page de recherche
	 * @return \Zend\View\Model\ViewModel
	 */
	private function createViewList($page) {
		$em=$this->getEntityManager();
		
		$piecesService=$this->getServiceLocator()->get('Piece\Service\Pieces');
		$firstRecord=($page-1)*10;
		if ($this->container->activeSearch=='last') {
			$resultSet=$piecesService->findLast($firstRecord);
			$nb=$piecesService->countPieces();
		} else {
			$resultSet=$piecesService->findByCriteria($this->container->criteria['searchRegionId'],$this->container->criteria['searchBrandId'],$this->container->criteria['searchAptId'],$this->container->criteria['searchPctId'],$firstRecord);
			$nb=$piecesService->countWithCriteria($this->container->criteria['searchRegionId'],$this->container->criteria['searchBrandId'],$this->container->criteria['searchAptId'],$this->container->criteria['searchPctId']);
		}
		if ($nb==0) $nb=1;
		$config=$this->getServiceLocator()->get('Configuration');
		//var_dump($config);
		//die();
		$maxPage=ceil($nb/$config['search_module']['line_per_page']);
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
		
		$this->buildLayout('lastPieces');
		
		//$view=new ViewModel(array('pieces',$resultSet));
		//$view->setTemplate('search/pieces/index');
		$viewModel=new ViewModel(array(
				'pieces' => $resultSet,
				'reg' => $reg,
				'brand' => $brand,
				'apt' => $apt,
				'pct' => $pct,
				'needSearchBar' => true,
				'page' => $this->activePage,
				'maxPage' => $maxPage,
				'activeSearch' => $this->container->activeSearch,
				'criteria' => ($this->container->activeSearch=='criteria') ? $this->container->criteria : array()
		));
		$viewModel->setTemplate('search/pieces/index');
		return $viewModel;		
	}
	
	/**
	 * Appelé lors de l'appel à l'URL /search
	 * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
	 */
	public function indexAction() {
		$this->activePage=1;
		$this->SetSession('last');
		return $this->createViewList(1);
	}
	
	/**
	 * Navigation dans les pages de recherche
	 */
	public function navAction() {
		$page=$this->params()->fromRoute('page',null);
		$this->activePage=$page;
		$this->SetSession(null);
		return $this->createViewList($page);
	}
	
	/**
	 * Retourne la liste des pièces suivant des critères de recherche
	 * @return ViewModel
	 */
	public function listAction() {
		$request=$this->getRequest();
		$searchRegionId=$request->getQuery('searchRegionId');
		$searchBrandId=$request->getQuery('searchBrandId');
		$searchAptId=$request->getQuery('searchAptId');
		$searchPctId=$request->getQuery('searchPctId');
		$this->activePage=1;
		$this->criteria=array('searchRegionId' => $searchRegionId,'searchBrandId' => $searchBrandId,'searchAptId' => $searchAptId,'searchPctId' => $searchPctId);
		$this->SetSession('criteria');
		return $this->createViewList(1);
	}

}
