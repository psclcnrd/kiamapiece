<?php

namespace Search\Form\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\ElementInterface;
use Search\Form\Element\MySelect as SelectElement;
use Zend\Form\Exception;

/**
 * Affichage d'un select g�rer par une table de choix Doctrine
 * 
 * @author Pascal CONRAD
 * @version 1.0 - 10/07/2014
 *        
 */
class MyFormSelect extends AbstractHelper
{

    /**
     * D�finition des attributs valide pour cet �l�ment.
     * Elles doivent �cras� des variables de la classe p�re comme parent::validTagAttributes
     * qui est utilis� par parent::createAttributesString pour tester si les valeurs des attributs
     * sont correcte.
     */
    
    /**
     * Attributes valid for select
     *
     * @var array
     */
    protected $validSelectAttributes = array(
    		'name'      => true,
    		'autofocus' => true,
    		'disabled'  => true,
    		'form'      => true,
    		'multiple'  => true,
    		'required'  => true,
    		'size'      => true
    );
    
    /**
     * Attributes valid for options
     *
     * @var array
    */
    protected $validOptionAttributes = array(
    		'disabled' => true,
    		'selected' => true,
    		'label'    => true,
    		'value'    => true,
    );
    
    /**
     * Attributes valid for option groups
     *
     * @var array
    */
    protected $validOptgroupAttributes = array(
    		'disabled' => true,
    		'label'    => true,
    );
    
    protected $translatableAttributes = array(
    		'label' => true,
    );
    
    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @return string|FormSelect
     */
    public function __invoke(ElementInterface $element = null)
    {
    	if (!$element) {
    		return $this;
    	}
    
    	return $this->render($element);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\View\Helper\Navigation\HelperInterface::render()
     *
     */
    public function render(ElementInterface $element)
    {
        if (!$element instanceof SelectElement) {
        	throw new Exception\InvalidArgumentException(sprintf(
        			'%s requires that the element is of type Datas\Form\Element\MySelect',
        			__METHOD__
        	));
        }
        $name   = $element->getName();
        if (empty($name) && $name !== 0) {
        	throw new Exception\DomainException(sprintf(
        			'%s requires that the element has an assigned name; none discovered',
        			__METHOD__
        	));
        }
        $attributes = $element->getAttributes();
        $attributes['name']=$name;
        // on traite la valeur afin de r�cup�rer la bonne valeur d'options
        $value=$element->getValue();
        $valueField=$element->getValueField();
        $goodValue=$value;
        if (is_object($value)) {
            $ao=(array)$value;
            foreach($ao as $ks => $vs) {
            	if (preg_match('/'.$valueField.'$/', $ks)) $goodValue=$vs;
            }
        }
        if (is_array($value) && (valueField!="")) {
            foreach($value as $ks => $vs) {
                if (preg_match('/'.$valueField.'$/', $ks)) $goodValue=$vs; 
            }
        }
        // on r�cup�re les options
        $options = $element->getValueOptions();
        $this->validTagAttributes = $this->validSelectAttributes;
        // on compose
        $rendered = sprintf(
        		'<select %s>%s</select>',
        		$this->createAttributesString($attributes),
        		$this->renderOptions($options, $goodValue)
        );
        //$render="<select name='$name'>".$this->renderOptions($options,$goodValue)."</select>";
        return $rendered;
    }
    
    /**
     * G�n�re la liste des options
     * @param array $options 
     * @param string $value
     */
    private function renderOptions($options,$valueSelected)
    {
        $optionSelect="";
        $this->validTagAttributes = $this->validOptionAttributes;
        foreach($options as $key => $text) {
            $value=$key;
            if ($key==$valueSelected) $selected=true;else $selected=false;
            $attributes=compact('value','selected');
            $optionSelect.="<option ".$this->createAttributesString($attributes).">$text</option>\n";
        }
        return $optionSelect;
    }
}

?>