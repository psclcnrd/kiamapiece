<?php
/**
 * Formulaire de saisie de changement de mot de passe
 * 
 * @author CONRAD Pascal
 * @version 1.0 15/01/2015
 *
 */

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\I18n\Translator\Translator;

class UserPasswordForm extends Form {
	
	/**
	 * Surcouche du constructeur de la classe Form
	 * @param $translator Service du translateur
	 * @param $em Service du DBM (Doctrine)
	 */
	public function __construct(Translator $translator) {
		parent::__construct ( 'MainUser' );
		$this->setAttribute('method', 'post');
		$this->add ( array (
				'name' => 'id',
				'attributes' => array(
				                       'type' => 'Hidden'
						             ) 
		));
		$this->add( array(
				'name' => 'csrf',
				'type' => 'Csrf',
				'options' => array(
						'csrf_options' => array(
								'timeout' => 600
						)
				)
		));
		$this->add( array(
				'name' => 'OldPassword',
				'required' => true,
				'type' => 'Password',
				'options' => array(
						'label' => $translator->translate('formOldPasswd','user')
				)
		));		
		$this->add( array(
				'name' => 'Password',
				'required' => true,
				'type' => 'Password',
				'options' => array(
						'label' => $translator->translate('formPasswd1','user')
				)
		));
		$this->add( array(
				'name' => 'PasswordRetype',
				'required' => true,
				'type' => 'Password',
				'options' => array(
						'label' => $translator->translate('formPasswd2','user')
				),
		));
		// Bouton d'envoi du formulaire
		$this->add(array(
			'name' => 'submit',
			'attributes' => array (
				'type' => 'Submit',					
			    'value' => $translator->translate('formSubmit','user'),
			    'id' => 'submitButton'
		    )
		));
	}
}