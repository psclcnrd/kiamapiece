<?php
namespace Search\Form\View\Helper;

use Zend\Form\View\Helper\FormInput;
use Zend\Form\ElementInterface;

/**
 * Affichage des champs texte sp�cifiques pour la gestion avec jQuery
 *
 * @author Pascal CONRAD
 * @version 1.0 19/08/2014
 *        
 */
class MyFormText extends FormInput
{
    /**
     * Attributes valid for the input tag type="text"
     *
     * @var array
     */
    protected $validTagAttributes = array(
    		'name'           => true,
    		'autocomplete'   => true,
    		'autofocus'      => true,
    		'dirname'        => true,
    		'disabled'       => true,
    		'form'           => true,
    		'list'           => true,
    		'maxlength'      => true,
    		'pattern'        => true,
    		'placeholder'    => true,
    		'readonly'       => true,
    		'required'       => true,
    		'size'           => true,
    		'type'           => true,
    		'value'          => true,
            'jqtype'         => true
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
     * Determine input type to use
     *
     * @param  ElementInterface $element
     * @return string
    */
    protected function getType(ElementInterface $element)
    {
    	return 'text';
    }
    
    /**
     * (non-PHPdoc)
     * @see \Zend\Form\View\Helper\FormInput::render()
     */
    public function render(ElementInterface $element) {
        $name   = $element->getName();
        if (empty($name) && $name !== 0) {
        	throw new Exception\DomainException(sprintf(
        			'%s requires that the element has an assigned name; none discovered',
        			__METHOD__
        	));
        }
        $attributes = $element->getAttributes();
        $attributes['name']=$name;
        $attributes['type']='text';
        $value=$element->getValue();
        $attributes['value']=$value;
        // on compose
        $rendered = sprintf(
        		'<input %s>',
        		$this->createAttributesString($attributes)
            );
        return $rendered;        
    }
}

?>