<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Piece for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Piece\Controller;

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
use Piece\Form\PiecesForm;

class PieceController extends ProjectActionController
{
	
	/**
	 * Tableau des meta title
	 * @var unknown
	 */
	protected $arrayTitle=array('addPiece' => 'meta_title_08','editPiece' => 'meta_title_09','viewPiece' => 'meta_title_09-1');

	/**
     * Ajout d'une nouvelle pièces
     */
    public function addAction() {
    	$auth=new AuthenticationService();
    	$auth->setStorage(new SessionStorage('kmpv1'));
    	if (!$auth->hasIdentity()) {
    		throw new \Exception('noLogin');
    	}
    	$form=new PiecesForm($this->getServiceLocator());
    	$request=$this->getRequest();
    	if ($request->isPost()) {
    		$pieces=new Pieces();
    		//$form->setInputFilter($pieces->getInputFilter());
    		$piecesService=$this->getServiceLocator()->get('Piece\Service\Pieces');
    		$form->setData($request->getPost());
    		if ($form->IsValid()) {
    			$auth=new AuthenticationService();
    			$auth->setStorage(new SessionStorage("kmpv1"));
    			$userId=$auth->getIdentity();
    			//---
    			$pieces->exchangeArray($form->getData(FormInterface::VALUES_AS_ARRAY));
    			$pieces->setUser($userId);
    			$pieces->setStatus(1);
    			$piecesService->prepare($pieces);
    			$piecesService->save($pieces);
    			$this->getLog()->info("A new piece is add by user id=".$userId." id=".$pieces->getId());
    			return $this->redirect()->toRoute('search');
    		}
    	}
    	$this->buildLayout('addPiece');
    	$viewModel=new ViewModel(array("form" => $form,"action" => "add"));
    	$viewModel->setTemplate("piece/piece/edit");
    	return $viewModel;
    }
    
    /**
     * Modification d'une nouvelle pièces
     */
    public function editAction() {
    	$id=$this->params()->fromRoute('id',null);
    	$auth=new AuthenticationService();
    	$auth->setStorage(new SessionStorage('kmpv1'));
    	if (!$auth->hasIdentity()) {
    		throw new \Exception('noLogin');
    	}
    	$piecesService=$this->getServiceLocator()->get('Piece\Service\Pieces');
    	$piece=$piecesService->findById($id);
    	if ($piece==null) {
    		throw new \Exception($this->getTranslator()->translate('error_NoIdent','search'));
    	}
    	if ($piece->getUser()->getId()!=$auth->getIdentity()) {
    		throw new \Exception($this->getTranslator()->translate('error_NoAtYou','search'));
    	}
    	$form=new PiecesForm($this->getServiceLocator());
    	$form->bind($piece);
    	$request=$this->getRequest();
    	if ($request->isPost()) {
    		$form->setData($request->getPost());
    		if ($form->IsValid()) {
    			$piecesService->prepare($piece);
    			$piecesService->save($piece);
    			return $this->redirect()->toRoute('user/view');
    		} else var_dump($request->getPost());
    	}
    	$this->buildLayout('editPiece');
    	$viewModel=new ViewModel(array("form" => $form,"action" => "edit","id" => $id));
    	$viewModel->setTemplate("piece/piece/edit");
    	return $viewModel;
    }
    
    /**
     * Supprimer une pièce mise à disposition
     */
    public function deleteAction() {
    	$id=$this->params()->fromRoute('id',null);
    	$auth=new AuthenticationService();
    	$auth->setStorage(new SessionStorage('kmpv1'));
    	if (!$auth->hasIdentity()) {
    		throw new \Exception('loLogin');
    		return $this->redirect()->toRoute('search');
    	}
    	$piecesService=$this->getServiceLocator()->get('Piece\Service\Pieces');
    	$piece=$piecesService->findById($id);
    	if ($piece==null) {
    		throw new \Exception($this->getTranslator()->translate('error_NoIdent','search'));
    	}
    	// on vérifie que c'est le même utilisateur qui supprime
    	if ($piece->getUser()->getId()!=$auth->getIdentity()) {
    		throw new \Exception($this->getTranslator()->translate('error_NoAtYou','search'));
    	} else {
    		$this->getLog()->info("A Piece is deleted id=".$piece->getId());
    		$piecesService->delete($piece);
    	}
    	return $this->redirect()->toRoute('user/view');
    }
    
    /**
     * Display one pieces informations
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function viewAction() {
    	$id=$this->params()->fromRoute('id',null);
    	$piecesService=$this->getServiceLocator()->get('Piece\Service\Pieces');
    	$pieces=$piecesService->findById($id);
    	$this->buildLayout('viewPiece');
    	return new ViewModel(array(
    			'pieces' => $pieces,
    	));
    }
    
}
