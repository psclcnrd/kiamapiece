<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Message for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Message\Controller;

use \Datetime;
use Search\Controller\ProjectActionController;
use Search\Models\Request;
use Search\Models\Messages;
use Message\Form\MessageForm;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Authentication\Storage\Session as SessionStorage;

class MessageController extends ProjectActionController
{
	
	/**
	 * Tableau des meta title
	 * @var unknown
	 */
	protected $arrayTitle=array('addMessage' => 'meta_title_10','listMessages' => 'meta_title_11','viewMessage' => 'meta_title_12','respondMessages' => 'meta_title_13');
    
	/**
	 * Ajoute un message
	 * 
	 * @throws \Exception
	 * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>|\Zend\View\Model\ViewModel
	 */
    public function addAction() {
    	$id=$this->params()->fromRoute('pieceId',null);
    	if ($id==null) {
    		return $this->redirect()->toRoute('error/404');
    	}
    	$auth=new AuthenticationService();
    	$auth->setStorage(new SessionStorage('kmpv1'));
    	if (!$auth->hasIdentity()) {
    		throw new \Exception('noLogin');
    	}
    	$requestsService=$this->getServiceLocator()->get('Request\Service\Request');
    	$usersService=$this->getServiceLocator()->get('User\Service\Users');
    	$messagesService=$this->getServiceLocator()->get('Message\Service\Messages');
    	$requestedPiece=$requestsService->findById($id);
    	$form=new MessageForm($this->getServiceLocator());
    	$request=$this->getRequest();
    	if ($request->isPost()) {
    		$message=new Messages();
    		$form->setData($request->getPost());
    		if ($form->isValid()) {
    			$message->exchangeArray($form->getData());
    			$message->setUserFrom($usersService->findById($requestedPiece->getUserApplicantId()));
    			$message->setUserTo($usersService->findById($requestedPiece->getUserDepositaryId()));
    			$message->setPiece($requestedPiece->getPiece());
    			$message->setCreateDate(new Datetime('now'));
    			$message->setMessageSee('N');
    			$message->setMessageBox('Sent');
    			$messagesService->save($message);
    			$messagesService->notifyNewMail($message->getId());
    			return $this->redirect()->toRoute('search');
    		}
    	}
    	$this->buildLayout('addMessage');
    	$viewModel=new ViewModel(array('form' => $form,'action' => 'add','id' => $id,'piece' => $requestedPiece->getPiece(),'me' => $auth->getIdentity(),'to' => $usersService->findById($requestedPiece->getUserDepositaryId())->getPseudo()));
    	$viewModel->setTemplate('message/edit');
    	return $viewModel;
    }
    
    /**
     * Affiche la liste des messages d'un utilisateur
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>|\Zend\View\Model\ViewModel
     */
    public function listAction() {
    	$auth=new AuthenticationService();
    	$auth->setStorage(new SessionStorage('kmpv1'));
    	if (!$auth->hasIdentity()) {
    		throw new \Exception('noLogin');
    	}
    	$messagesService=$this->getServiceLocator()->get('Message\Service\Messages');
    	//$allMessages=$messagesService->findByUserDepositary($auth->getIdentity());
    	$allMessages=$messagesService->findAll($auth->getIdentity());
    	$this->buildLayout('listMessages');
    	$viewModel=new ViewModel(array('messages' => $allMessages,'me' => $auth->getIdentity()));
    	$viewModel->setTemplate('message/list');
    	return $viewModel;
    }

    /**
     * Afficher un message
     * @return \Zend\View\Model\ViewModel
     */
    public function viewAction() {
    	$id=$this->params()->fromRoute('id',null);
    	$auth=new AuthenticationService();
    	$auth->setStorage(new SessionStorage('kmpv1'));
    	if (!$auth->hasIdentity()) {
    		throw new \Exception('noLogin');
    	}
    	$messagesService=$this->getServiceLocator()->get('Message\Service\Messages');
    	$message=$messagesService->findById($id);
    	if ($message->getUserFrom()->getId()!=$auth->getIdentity()) {
    		$message->setMessageSee('Y');
    		$messagesService->save($message);
    	}
    	$this->buildLayout('viewMessage');
    	$viewModel=new ViewModel(array('message' => $message,'me' => $auth->getIdentity()));
    	$viewModel->setTemplate('message/view');
    	return $viewModel;    	
    }
    
    /**
     * Répondre à un mail
     * @throws \Exception
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>|\Zend\View\Model\ViewModel
     */
    public function respondAction() {
    	$id=$this->params()->fromRoute('id',null);
    	$auth=new AuthenticationService();
    	$auth->setStorage(new SessionStorage('kmpv1'));
    	if (!$auth->hasIdentity()) {
    		throw new \Exception('noLogin');
    	}
    	$messagesService=$this->getServiceLocator()->get('Message\Service\Messages');
    	$requestsService=$this->getServiceLocator()->get('Request\Service\Request');
    	$usersService=$this->getServiceLocator()->get('User\Service\Users');
    	$originMessage=$messagesService->findById($id);
    	if ($originMessage==null) {
    		throw new \Exception('noMessage');
    	}
    	$form=new MessageForm($this->getServiceLocator());
    	$request=$this->getRequest();
    	if ($request->isPost()) {
    		$message=new Messages();
    		$message->setUserFrom($originMessage->getUserTo());
    		$message->setUserTo($originMessage->getUserFrom());
    		$message->setPiece($originMessage->getPiece());
    		$message->setMessageSee('N');
    		$form->setData($request->getPost());
    		if ($form->isValid()) {
    			$message->exchangeArray($form->getData());
    			$message->setCreateDate(new Datetime('now'));
    			$message->setMessageBox('Sent');
    			$messagesService->save($message);
    			$messagesService->notifyNewMail($message->getId());
    			return $this->redirect()->toRoute('message/list');
    		}
    	}
    	$this->buildLayout('respondMessages');
    	$viewModel=new ViewModel(array('form' => $form,'action' => 'respond','id' => $id,'piece' => $originMessage->getPiece(),'me' => $auth->getIdentity(),'to' => $usersService->findById($originMessage->getUserFrom())->getPseudo()));
    	$viewModel->setTemplate('message/edit');
    	return $viewModel;
    }
}
