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

class UserAddForm extends Form {
	
	/**
	 * Surcouche du constructeur de la classe Form
	 * @param $translator Service du translateur
	 * @param $em Service du DBM (Doctrine)
	 */
	public function __construct(Translator $translator,EntityManager $em) {
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
						'size' => '40'
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
						'size' => '15'
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
		$this->add( array(
			'name' => 'Name',
			'required' => true,
            'type' => 'Text',
			'options' => array(
			   'label' => $translator->translate('formName','user')
		     ),
				'attributes' => array(
						'size' => '35'
				)
		));
		$this->add( array(
				'name' => 'Surname',
				'required' => true,
                'type' => 'Text',
				'options' => array(
						'label' => $translator->translate('formSurname','user')
				)
		));
		$this->add(array(
			'name' => 'Phone1',
            'type' => 'User\Form\Element\Phone',
			'options' => array(
			                   'label' => $translator->translate('formPhone1','user')
		                    )
		));
		// 2ème téléphone
		$this->add(array(
				'name' => 'Phone2',
				'type' => 'Text',
				'required' => false,
				'options' => array(
						'label' => $translator->translate('formPhone2','user')
				)
		));
		// Numéro de maison		
		$this->add(array(
				'name' => 'Number',
				'type' => 'Text',
				'required' => false,
				'options' => array(
						'label' => $translator->translate('formNumber','user')
				)				
		));
		// Nom de la rue
		$this->add(array(
				'name' => 'Street',
				'type' => 'Text',
				'required' => true,
				'options' => array(
						'label' => $translator->translate('formStreet','user')
				),
				'attributes' => array(
						'size' => '40'
				)
		));
		// Nom de la rue
		$this->add(array(
				'name' => 'Complement',
				'type' => 'Text',
				'required' => false,
				'options' => array(
						'label' => $translator->translate('formComplement','user')
				),
				'attributes' => array(
						'size' => '40'
				)
		));		
		// Code Postal		
		$this->add(array(
				'name' => 'PostalCode',
				'type' => 'Text',
				'required' => true,
				'options' => array(
						'label' => $translator->translate('formPostalCode','user')
				),
				'attributes' => array(
						'size' => '5'
				)
		));
		// Ville (select alimenté par le code postal)
		$this->add(array(
				'name' => 'Town',
				'type' => 'Text',
				'required' => true,
				'options' => array(
						'label' => $translator->translate('formTown','user')
				),
				'attributes' => array(
						'size' => '35'
				)
		));		
		// Selection de la région
		$this->add(array(
				'name' => 'RegionId',
				'type' => 'Search\Form\Element\MySelect',
				'required' => true,
				'options' => array(
						'entity' => 'Search\Models\Region',
						'em' => $em,
						'label' => $translator->translate('Region','user'),
						'valueField' => 'id',
						'textField' => 'Description',
						'orderBy' => 'Description'
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