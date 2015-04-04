<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/User for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * 
 * Controleur des actions utilisateurs
 * @author CONRAD Pascal
 * @version 1.0 03/05/2014
 */

namespace User\Controller;

use Search\Controller\ProjectActionController;
use User\Form\UserAddForm;
use User\Form\UserEditForm;
use User\Form\UserPasswordForm;
use User\Form\UserPasswordEmailForm;
use User\Form\UserPasswordLostForm;
use Search\Models\MainUser;
use Search\Models\Addresses;
use Search\Service\UsersService;
use Search\Service\AddressesService;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use User\Controller\UserAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Mail\Storage;

class UserController extends ProjectActionController
{

	/**
	 * Tableau des meta title
	 * @var unknown
	 */
	protected $arrayTitle=array('addUser' => 'meta_title_01','editUser' => 'meta_title_02','editPassword' => 'meta_title_03','validateUser' => 'meta_title_04','validPassword' => 'meta_title_05','lostPassword' => 'meta_title_06','viewUser' => 'meta_title_06-1');

    /**
     * Ajouter un utilisateur
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>|multitype:\User\Form\UserAddForm
     */
    public function addAction()
    {
    	$em=$this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $form=new UserAddForm($this->getTranslator(),$em);
        $request=$this->getRequest();
        if ($request->isPost()) {
        	// création de nouveau enregistrement
        	$user=new MainUser();
        	$address=new Addresses();
        	// on met en place les 'validators'
        	$form->setInputFilter($user->getInputFilter());
        	// le formulaire recupères les données du post
        	$form->setData($request->getPost());
        	//$this->getLog()->info(print_r($request->getPost(),true));
        	// on teste si la saisie est valide
        	if ($form->isValid()) {
        		$userService=$this->getUsersService();
        		$addService=$this->getServiceLocator()->get('User\Service\Addresses');
        		$user->exchangeArray($form->getData());
        		$address->exchangeArray($form->getData());
        		$address->AddressName=$this->getTranslator()->translate('Principale','user');
        		$address->MainAddress='Y';
                $userService->save($user);
        		$address->UserId=$user->getId();
        		$addService->save($address);
        		$userService->ExecuteValidation($user->getId());
        		$this->getLog()->info("User ID=".$user->getId()." created, waiting validation.");
        		return $this->redirect()->toRoute('search');
        	}
        }
        $this->buildLayout('addUser');
        $viewModel=new ViewModel(array('form' => $form,'action' => 'add'));
        $viewModel->setTemplate('user/edit_user');
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
    	$form=new UserEditForm($this->getTranslator());
    	$request=$this->getRequest();
    	$userService=$this->getUsersService();
    	$user=$userService->findById($id);
    	$form->bind($user);
    	if ($request->isPost()) {
    		// création de nouveau enregistrement
    		// on met en place les 'validators'
    		$form->setInputFilter($user->getInputFilterReduced());
    		// le formulaire recupères les données du post
    		$form->setData($request->getPost());
    		// on teste si la saisie est valide
    		if ($form->isValid()) {
    			$userService->save($user);
    			$this->getLog()->info("User ID=".$user->getId()." change profile information.");
    			return $this->redirect()->toRoute('user/view');
    		}
    	}
    	$this->buildLayout('editUser');
    	$viewModel=new ViewModel(array('form' => $form,'action' => 'edit','id' => $id));
    	$viewModel->setTemplate('user/edit_user');
    	return $viewModel;
    }

    /**
     * Changer le mot de passe utilisateur
     * @throws \Exception
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>|\Zend\View\Model\ViewModel
     */
    public function pwdAction()
    {
    	$id=$this->params()->fromRoute('id',null);
    	$auth=new AuthenticationService();
    	$auth->setStorage(new SessionStorage('kmpv1'));
    	if (!$auth->hasIdentity()) {
    		throw new \Exception('noLogin');
    	}
    	$em=$this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    	$form=new UserPasswordForm($this->getTranslator());
    	$request=$this->getRequest();
    	$userService=$this->getUsersService();
    	$user=$userService->findById($id);
    	if ($user==null) {
    		throw new \Exception('noId');
    	}
    	if ($request->isPost()) {
    		// le formulaire recupères les données du post
    		$data=$request->getPost();
    		$form->setData($data);
    		// on teste si la saisie est valide
    		if ($form->isValid() && $userService->controlPassword($id,$data["OldPassword"])) {
    			$userService->updatePassword($id,$data["Password"]);
    			$this->getLog()->info("User ID=".$user->getId()." as changed is password");
    			return $this->redirect()->toRoute('user/view');
    		}
    	}
    	$this->buildLayout('editPassword');
    	$viewModel=new ViewModel(array('form' => $form,'action' => 'pwd','id' => $id));
    	$viewModel->setTemplate('user/edit_pwd');
    	return $viewModel;
    }

    /**
     * Affichage des information d'un utilisateur
     * @return \Zend\View\Model\ViewModel|multitype:
     */
    public function viewAction()
    {
    	$auth=new AuthenticationService();
    	$auth->setStorage(new SessionStorage('kmpv1'));
    	if ($auth->hasIdentity()) {
    		$id=$auth->getIdentity();
    		$userService=$this->getServiceLocator()->get('User\Service\Users');
    		$piecesService=$this->getServiceLocator()->get('Piece\Service\Pieces');
    		$requestsService=$this->getServiceLocator()->get('Request\Service\Request');
			$user=$userService->findById($id);
			$allPieces=$piecesService->findByUser($id);
			$allRequest=$requestsService->findByUserApplicant($id);
	        // On construit la vue
	        $this->buildLayout('viewUser');
	    	return new ViewModel(array('user' => $user,'pieces' => $allPieces,'request' => $allRequest));
    	}
    	return $this->redirect()->toRoute('search');
    }

    /**
     * Login d'un utilisateur connu
     * @return \Zend\View\Model\JsonModel
     */
    public function loginAction() {
    	$request=$this->getRequest();
    	$id=$request->getQuery('log_id');
    	$pw=$request->getQuery('log_pwd');
    	$em=$this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    	
        $adapter=new UserAdapter($id,$pw,$em);
        $auth=new AuthenticationService();
        $auth->setStorage(new SessionStorage("kmpv1"));
        $result=$auth->authenticate($adapter);
    	if ($result->isValid()) {
    		$userService=$this->getServiceLocator()->get('User\Service\Users');
    		$user=$userService->findById($result->getIdentity());
    		$userService->setLastActivity($user->getId());
    		$json=array("status" => "OK","user" => $user);
    		$this->getLog()->info("User connection ID=".$user->getId());
  		} else {
  			$json=array("status" => "BAD");
  		}
    	return new JsonModel($json);
    }
    
    /**
     * Déconnection d'un utilisateur
     * @return multitype:
     */
    public function logoutAction() {
    	$auth=new AuthenticationService();
    	$auth->setStorage(new SessionStorage("kmpv1"));
    	$this->getLog()->info("User deconnection ID=".$auth->getIdentity());
    	$auth->clearIdentity();
    	return $this->redirect()->toRoute('search');
    }
    
    /**
     * Valide une création de compte
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>
     */
    public function validateAction() {
    	$control=$this->params()->fromRoute('ctrl',null);
    	if ($control==null) {
    		return $this->redirect()->toRoute('search');
    	}
    	$userService=$this->getServiceLocator()->get('User\Service\Users');
    	$id=$userService->validate($control);
    	if ($id!==false) $this->getLog()->info("User ID=".$id." validation complete");
    	  else $this->getLog()->alert("Error in validation from control=$control");
    	$this->buildLayout('validateUser');
    	return new ViewModel(array());
    }
    
    /**
     * Mot de passe oublié ?
     * @return \Zend\View\Model\ViewModel
     */
    public function lostpwdAction() {
    	$form=new UserPasswordEmailForm($this->getTranslator());
    	$request=$this->getRequest();
    	if ($request->isPost()) {
    		$form->setData($request->getPost());
    		if ($form->isValid()) {
    			$email=$request->getPost('Email');
    			$userService=$this->getServiceLocator()->get('User\Service\Users');
    			$userService->LostProcedure($email);
    			$this->redirect()->toRoute('search');
    		}
    	}
    	$this->buildLayout('lostPassword');
    	$viewModel=new ViewModel(array('form' => $form));
    	$viewModel->setTemplate('user/lost_pwd');
    	return $viewModel;    	
    }
    
    /**
     * Validation du changement de mot de passe
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>|\Zend\View\Model\ViewModel
     */
    public function validpwdAction() {
    	$control=$this->params()->fromRoute('ctrl',null);
    	if ($control==null) {
    		return $this->redirect()->toRoute('search');
    	}
    	$form=new UserPasswordLostForm($this->getTranslator());
    	$request=$this->getRequest();
    	if ($request->isPost()) {
    		$form->setData($request->getPost());
    		if ($form->isValid()) {
    			// le control est bon ?
    			$userService=$this->getServiceLocator()->get('User\Service\Users');
    			$id=$userService->validatePwdChange($control);
    			if ($id===false) return $this->redirect()->toRoute('search');
    			// Ok, on continu
    			$password=$request->getPost('Password');
    			$userService->updatePassword($id,$password);
    			$this->redirect()->toRoute('search');
    		}
    	}
    	$this->buildLayout('validPassword');
    	$viewModel=new ViewModel(array('form' => $form,'ctrl' => $control));
    	$viewModel->setTemplate('user/lost_pwd2');
    	return $viewModel;
    }
    
    /**
     * Recherche les contôles obsolètes
     */
    public function mntAction() {
    	$userService=$this->getServiceLocator()->get('User\Service\Users');
    	$cnt=$userService->deleteOldControl();
    	if ($cnt) $status='OK';else $status='EMPTY';
    	return new JsonModel(array('status' => $status, 'cnt' => $cnt)); 
    }
}
