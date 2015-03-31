<?php
/**
 * Formulaire de saisie d'une adresse mail valide quand celui-ci est perdu
 * 
 * @author CONRAD Pascal
 * @version 1.0 01/05/2014
 *
 */

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\I18n\Translator\Translator;

class UserPasswordEmailForm extends Form {
	
	/**
	 * Surcouche du constructeur de la classe Form
	 * @param $translator Service du translateur
	 * @param $em Service du DBM (Doctrine)
	 */
	public function __construct(Translator $translator) {
		parent::__construct ( 'MainUser' );
		$this->setAttribute('method', 'post');
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
				'name' => 'Email',
				'required' => true,
				'type' => 'Email',
				'options' => array(
						'label' => $translator->translate('PwdLost_formEmail','user')
				)
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