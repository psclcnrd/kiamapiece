<?php

namespace Message\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\I18n\Translator\Translator;

class MessageForm extends Form {
	
	/**
	 * Contructeur de la classe
	 * @param ServiceLocatorInterface $sl
	 */
	public function __construct(ServiceLocatorInterface $sl) {
		parent::__construct('Message');
		$translator=$sl->get('translator');
		$this->setAttribute('method','post');
		$this->add(array(
				'name' => 'id',
				'type' => 'hidden'
		));
		$this->add(array(
				'name' => 'Message',
				'type' => 'Zend\Form\Element\Textarea',
				'required' => false,
				'options' => array(
						'label' => $translator->translate('EditMessage_Message','search'),
				),
				'attributes' => array('cols' => 80,'rows' => 10)
		));
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type' => 'submit',
						'label' => $translator->translate('EditMessage_Submit','search'),
						'value' => 'valider'
				)
		
		));		
	}
}

?>