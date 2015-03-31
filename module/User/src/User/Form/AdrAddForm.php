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
use Zend\ServiceManager\ServiceLocatorInterface;

class AdrAddForm extends Form {
	
	/**
	 * Surcouche du constructeur de la classe Form
	 * @param $translator Service du translateur
	 * @param $em Service du DBM (Doctrine)
	 */
	public function __construct(ServiceLocatorInterface $sl) {
		parent::__construct ('Address');
		$em=$sl->get('doctrine.entitymanager.orm_default');
		$translator=$sl->get('translator');
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
		// Nom de la rue
		$this->add(array(
				'name' => 'AddressName',
				'type' => 'Text',
				'required' => true,
				'options' => array(
						'label' => $translator->translate('formAdrName','user')
				)
		));
		// Numéro de maison		
		$this->add(array(
				'name' => 'Number',
				'type' => 'Text',
				'required' => false,
				'options' => array(
						'label' => $translator->translate('formNumber','user')
				),
				'validators' => array(
						'name' => 'Digits'
				),
				'attributes' => array(
						'size' => '10'
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
				'required' => true,
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
 				'validators' => array(
 						'name' => 'Digits'
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
		/*$this->add(array(
				'name' => 'Town',
				'type' => 'Select',
				'required' => true,
				'options' => array(
						'label' => $translator->translate('formTown','user'),
						'value_options' => array(),
						'empty_option' => $translator->translate('formEmptyTown','user'),
						'disable_inarray_validator' => true
				)
		));*/		
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
		
/*		$regions=new Element\Select('RegionId');
		$regions->setLabel($translator->translate('Region','user'));
		$query=$em->createQuery("select r from Search\Models\Region r order by r.Description");
		$result=$query->getResult();
		$rr=array();
		foreach ($result as $r) $rr["$r->id"]=$r->Description;
		$regions->setValueOptions($rr);
		// on ajoute au formulaire
		$this->add($regions);*/
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