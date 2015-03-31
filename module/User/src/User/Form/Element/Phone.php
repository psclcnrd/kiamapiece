<?php

namespace User\Form\Element;

use Zend\InputFilter\InputProviderInterface;
use Zend\Form\Element;
use Zend\Validator\Regex as RegexValidator;
//use Zend\Session\Validator\ValidatorInterface;

class Phone extends Element implements InputProviderInterface {
	
	protected $validator;
	
	public function getValidator() {
		if ($this->validator===null) {
			$validator=new RegexValidator('/^0[1-9][0-9]{8}$/');
			$validator->setMessage("10 Caractères pour un numéro de téléphone SVP",RegexValidator::NOT_MATCH);
			$this->validator=$validator;
		}
		return $this->validator;
	}
	
	public function setValidator(ValidatorInterface $validator) {
		$this->validator=$validator;
		return $this;
	}
	
	public function getInputSpecification() {
		return array(
			'name' => $this->getName(),
			'filters' => array(
			                     array('name' => 'Zend\Filter\StringTrim')
		                      ),
			'validators' => array(
					               $this->getValidator()
			                     ) 
		);
	}
}

?>