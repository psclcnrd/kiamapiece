<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Request for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Request\Controller;

use \Datetime;
use \Exception;
use Search\Controller\ProjectActionController;
use User\Controller\UserAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Search\Models\Request;

class RequestController extends ProjectActionController
{
    public function indexAction()
    {
        return array();
    }

    /**
     * Ajoute une pièce à une demande
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>
     */
    public function doAction() {
    	$id=$this->params()->fromRoute('id',null);
    	$auth=new AuthenticationService();
    	$auth->setStorage(new SessionStorage('kmpv1'));
    	if (!$auth->hasIdentity()) {
    		throw new Exception('noLogin');
    	}    	
    	$piecesService=$this->getServiceLocator()->get('Piece\Service\Pieces');
    	$piece=$piecesService->findById($id);
    	// la pièce appartient à la même personne !!!! ????
    	if ($piece->getUser()->getid()==$auth->getIdentity()) {
    		throw new Exception('request_SameUser');
    	}
    	//----
    	$requestsService=$this->getServiceLocator()->get('Request\Service\Request');
    	$userService=$this->getServiceLocator()->get('User\Service\Users');
    	$request=new Request();
    	$request->setUserDepositaryId($piece->getUser()->getId());
    	$request->setUserApplicantId($auth->getIdentity());
    	$request->setPiece($piece);
    	$request->setDateRequest(new Datetime('now'));
    	$requestsService->save($request);
    	// Changement du statut de la pièce
    	$piece->setStatus(2);
    	$piecesService->prepare($piece);
    	$piecesService->save($piece);
    	$this->getLog()->info("A request for a piece id=".$piece->getId()." for id=".$auth->getIdentity());
    	$requestsService->notifyDepositary($request,$userService->findById($auth->getIdentity()),$piece->getUser()," est intéressé par votre piece");
    	return $this->redirect()->toRoute('search');
    }
    
    /**
     * Notify a request is receive
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>
     */
    public function receiveAction() {
    	$id=$this->params()->fromRoute('id',null);
    	$auth=new AuthenticationService();
    	$auth->setStorage(new SessionStorage('kmpv1'));
    	if (!$auth->hasIdentity()) {
    		throw new Exception('noLogin');
    	}
    	$piecesService=$this->getServiceLocator()->get('Piece\Service\Pieces');
    	$requestsService=$this->getServiceLocator()->get('Request\Service\Request');
    	$request=$requestsService->findById($id);
    	$piece=$piecesService->findById($request->getPiece());
    	if ($piece==null) {
    		throw new \Exception($this->getTranslator()->translate('error_NoIdent','search'));
    	}
    	$piece->setStatus(3);
    	$piecesService->prepare($piece);
    	$piecesService->save($piece);
    	$this->getLog()->info("A piece is receive id=".$piece->getId());
    	$userService=$this->getServiceLocator()->get('User\Service\Users');
    	$requestsService->notifyDepositary($request,$userService->findById($auth->getIdentity()),$piece->getUser()," a reçu votre pièce. Fin de transaction");
    	return $this->redirect()->toRoute('user/view');
    }
    
    /**
     * Delete a request
     */
    public function delAction() {
    	$id=$this->params()->fromRoute('id',null);
    	$auth=new AuthenticationService();
    	$auth->setStorage(new SessionStorage('kmpv1'));
    	if (!$auth->hasIdentity()) {
    		throw new Exception('noLogin');
    	}
    	$piecesService=$this->getServiceLocator()->get('Piece\Service\Pieces');
    	$requestsService=$this->getServiceLocator()->get('Request\Service\Request');
    	$request=$requestsService->findById($id);
    	$piece=$piecesService->findById($request->getPiece());
    	if ($piece==null) {
    		throw new \Exception($this->getTranslator()->translate('error_NoIdent','search'));
    	}
    	$piece->setStatus(1);
    	$piecesService->prepare($piece);
    	$piecesService->save($piece);
    	$requestsService->delete($request);
    	$this->getLog()->info("A request is cancel for id=".$piece->getId());
    	$userService=$this->getServiceLocator()->get('User\Service\Users');
    	$requestsService->notifyDepositary($request,$userService->findById($auth->getIdentity()),$piece->getUser()," a annulé la transaction.");
    	return $this->redirect()->toRoute('user/view');
    }
}
