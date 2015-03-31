<?php
/**
 * Formulaire de saisie d'un utilisateur
 * 
 * @author CONRAD Pascal
 * @version 1.0 01/05/2014
 *
 */

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\I18n\Translator\Translator;
use Doctrine\ORM\EntityManager;
use Search\Models\Region;

class UserEditForm extends Form {
	
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
				'name' => 'Email',
				'required' => true,
				'type' => 'Email',
				'options' => array(
						'label' => $translator->translate('formEmail','user')
				),
				'attributes' => array(
						'size' => '80'
				)
		));
		$this->add( array(
				'name' => 'Pseudo',
				'required' => true,
				'type' => 'Text',
				'options' => array(
						'label' => $translator->translate('formPseudo','user')
				),
				'attributes' => array(
						'size' => '20'
				)
		));
		$this->add( array(
			'name' => 'Name',
			'required' => true,
            'type' => 'Text',
			'options' => array(
			   'label' => $translator->translate('formName','user')
		     ),
			'attributes' => array(
						'size' => '40'
				)
		));
		$this->add( array(
				'name' => 'Surname',
				'required' => true,
                'type' => 'Text',
				'options' => array(
						'label' => $translator->translate('formSurname','user')
				),
				'attributes' => array(
						'size' => '40'
				)
		));
		$this->add(array(
			'name' => 'Phone1',
            'type' => 'User\Form\Element\Phone',
			'options' => array(
			                   'label' => $translator->translate('formPhone1','user')
		                    ),
			'attributes' => array(
						'size' => '10'
				)
		));
		// 2ème téléphone
		$this->add(array(
				'name' => 'Phone2',
				'type' => 'User\Form\Element\Phone',
				'required' => false,
				'options' => array(
						'label' => $translator->translate('formPhone2','user')
				),
				'attributes' => array(
						'size' => '10'
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