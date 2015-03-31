<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Contact for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Contact\Controller;

use Search\Controller\ProjectActionController;
use Contact\Form\ContactForm;
use Contact\Form\ContactFormFree;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\View\Model\ViewModel;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class ContactController extends ProjectActionController
{
	
    public function indexAction()
    {
    	$auth=new AuthenticationService();
    	$auth->setStorage(new SessionStorage('kmpv1'));
    	if (!$auth->hasIdentity()) {
    		throw new \Exception('noLogin');
    	}
    	$usersService=$this->getServiceLocator()->get('User\Service\Users');
    	$user=$usersService->findById($auth->getIdentity());
    	$form=new ContactForm($this->getServiceLocator());
    	$request=$this->getRequest();
    	if ($request->isPost()) {
    		$form->setData($request->getPost());
    		if ($form->isValid()) {
    			$a=$form->getData();
    			$mail=new Message();
    			$mail->setEncoding("UTF-8");
    			$mail->addFrom($user->getEmail());
    			$mail->addTo("pascal.conrad@gmail.com");
    			$mail->setSubject("kiamapiece.fr : un mail du site.");
    			$htmlPart=new MimePart($a["Message"]);
    			$htmlPart->type="text/html";
    			$body=new MimeMessage();
    			$body->setParts(array($htmlPart));
    			$mail->setBody($body);
    			//---
    			$transport=new SmtpTransport();
    			$config=$this->getServiceLocator()->get('Configuration');
    			$options=new SmtpOptions($config['smtp_options']);
    			$transport->setOptions($options);
    			$transport->send($mail);
    			return $this->redirect()->toRoute('search');    			
    		}
    	}
    	$this->buildLayout('editContact');
        return new ViewModel(array('form' => $form,'from' => $user->getEmail()));
    }
    
    /**
     * Contact libre
     * @throws \Exception
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>|\Zend\View\Model\ViewModel
     */
    public function indexfreeAction()
    {
    	$form=new ContactFormFree($this->getServiceLocator());
    	$request=$this->getRequest();
    	if ($request->isPost()) {
    		$form->setData($request->getPost());
    		if ($form->isValid()) {
    			$a=$form->getData();
    			$mail=new Message();
    			$mail->setEncoding("UTF-8");
    			$mail->addFrom($a['EmailFreeForm']);
    			$mail->addTo("pascal.conrad@gmail.com");
    			$mail->setSubject("kiamapiece.fr : un mail du site par formulaire libre.");
    			$htmlPart=new MimePart($a["Message"]);
    			$htmlPart->type="text/html";
    			$body=new MimeMessage();
    			$body->setParts(array($htmlPart));
    			$mail->setBody($body);
    			//---
    			$transport=new SmtpTransport();
    			$config=$this->getServiceLocator()->get('Configuration');
    			$options=new SmtpOptions($config['smtp_options']);
    			$transport->setOptions($options);
    			$transport->send($mail);
    			return $this->redirect()->toRoute('search');
    		}
    	}
    	$this->buildLayout('editContactfree');
    	return new ViewModel(array('form' => $form));
    }

    /**
     * Affichage des mentions légale
     * @return \Zend\View\Model\ViewModel
     */
    public function mentionAction() {
    	$this->buildLayout('mention');
    	return new ViewModel(array());
    }
}
