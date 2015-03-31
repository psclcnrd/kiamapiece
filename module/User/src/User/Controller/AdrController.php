<?php

namespace User\Controller;

use Search\Controller\ProjectActionController;
use Zend\View\Model\ViewModel;
use User\Form\AdrAddForm;
use Search\Models\Addresses;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

/**
 * AdrController
 *
 * @author CONRAD Pascal
 *
 * @version  1.0 28/12/2014
 *
 */
class AdrController extends ProjectActionController {
	
	/**
	 * Ajouter un utilisateur
	 * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>|multitype:\User\Form\UserAddForm
	 */
	public function addAction()
	{
		$auth=new AuthenticationService();
		$auth->setStorage(new SessionStorage('kmpv1'));
		if (!$auth->hasIdentity()) {
			throw new \Exception('noLogin');
		}
		$id=$auth->getIdentity();
		$em=$this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$form=new AdrAddForm($this->getServiceLocator());
		$request=$this->getRequest();
		if ($request->isPost()) {
			// création de nouveau enregistrement
			$address=new Addresses();
			// on met en place les 'validators'
			//$form->setInputFilter($user->getInputFilter());
			// le formulaire recupères les données du post
			$form->setData($request->getPost());
			//$this->getLog()->info(print_r($request->getPost(),true));
			// on teste si la saisie est valide
			if ($form->isValid()) {
				$addService=$this->getServiceLocator()->get('User/Service/Addresses');
				$userService=$this->getServiceLocator()->get('User/Service/Users');
				$user=$userService->findById($id);
				$address->exchangeArray($form->getData());
				$address->UserId=$user;
				$address->MainAddress='N';
				$addService->save($address);
				return $this->redirect()->toRoute('search');
			}
		}
		$this->buildLayout();
		$viewModel=new ViewModel(array('form' => $form,'action' => 'add'));
		$viewModel->setTemplate('user/edit_adr');
		return $viewModel;
	}
	
	/**
	 * Edit a user
	 * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>|multitype:\User\Form\UserAddForm
	 */
	public function editAction()
	{
		$id=$this->params()->fromRoute('id',null);
		$auth=new AuthenticationService();
		$auth->setStorage(new SessionStorage('kmpv1'));
		if (!$auth->hasIdentity()) {
			throw new \Exception('noLogin');
		}
		$em=$this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$form=new AdrAddForm($this->getServiceLocator());
		$request=$this->getRequest();
		$adrService=$this->getServiceLocator()->get('User\Service\Addresses');
		$address=$adrService->findById($id);
		if ($address==null) throw new \Exception('notFound');
		$form->bind($address);
		if ($request->isPost()) {
			// création de nouveau enregistrement
			// on met en place les 'validators'
			//$form->setInputFilter($user->getInputFilter());
			// le formulaire recupères les données du post
			$form->setData($request->getPost());
			// on teste si la saisie est valide
			if ($form->isValid()) {
				$adrService->save($address);
				return $this->redirect()->toRoute('user/view');
			}
		}
		$this->buildLayout();
		$viewModel=new ViewModel(array('form' => $form,'action' => 'edit','id' => $id));
		$viewModel->setTemplate('user/edit_adr');
		return $viewModel;
	}
}