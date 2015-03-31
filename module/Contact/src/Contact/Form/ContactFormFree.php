<?php

namespace Contact\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\I18n\Translator\Translator;

class ContactFormFree extends Form {
	function __construct(ServicelocatorInterface $sl) {
		parent::__construct('contact');
		$translator=$sl->get('translator');
		$this->setAttribute('method','post');
		$this->add(array(
				'name' => 'EmailFreeForm',
				'type' => 'Zend\Form\Element\Email',
				'required' => true,
				'options' => array(
						'label' => $translator->translate('EditMessage_Email','message'),
				),
				'attributes' => array('size' => 80)
		));
		$this->add(array(
				'name' => 'Message',
				'type' => 'Zend\Form\Element\Textarea',
				'required' => true,
				'options' => array(
						'label' => $translator->translate('EditMessage_Message','message'),
				),
				'attributes' => array('cols' => 80,'rows' => 10)
		));
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type' => 'submit',
						'label' => $translator->translate('EditMessage_Submit','message'),
						'value' => 'valider'
				)
		
		));
	}
}

?>