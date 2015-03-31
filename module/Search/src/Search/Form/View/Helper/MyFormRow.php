<?php

namespace Search\Form\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\View\Helper\FormLabel;
use Zend\Form\View\Helper\FormElement;
use Zend\Form\View\Helper\FormElementErrors;
use Zend\Form\ElementInterface;
use Zend\Form\LabelAwareInterface;

/**
 * Gestion des lignes de saisies des formulaires
 * 
 * @author Pascal CONRAD
 * @version 1.0 05/07/2014
 * @version 1.1 19/08/2014 Ajout gestion des champs text/jQuery
 * @version 1.2 04/09/2014 Ajout des 'helpTag' 
 *  
 */
class MyFormRow extends AbstractHelper
{
    
    protected $elementHelper;
    protected $labelHelper;
    protected $elementErrorHelper;

    /**
     * Utiliser $this->MyFormRow($form->get(name))
     * @param ElementInterface $elem
     * @return string
     */
    public function __invoke(ElementInterface $elem)
    {
        return $this->render($elem);
    }
    
    /**
     * Affichage des donn�es
     * @param ElementInterface $elem
     * @return string
     */
    public function render(ElementInterface $elem) {
        $labelHelper         = $this->getLabelHelper();
        switch ($elem->getAttribute('type')) {
        	case 'myselect' : $elementHelper=new MyFormSelect();
        	break;
        	case 'mydate' : $elementHelper=new MyFormText();
        	break;        	
        	default : $elementHelper=$this->getElementHelper();
        	break;
        }

        $elementErrorHelper  = $this->getElementErrorHelper();
        
        $label=$elem->getLabel($elem);
        $element=$elementHelper->render($elem);
        $error=$elementErrorHelper->render($elem);
        // Options sp�cifiques ****
        $rowOption=array();
        if ($elem->getOption("helptag")) {
            $htArray=$elem->getOption("helptag");
            $rowOption[]="<span class='btHelpTag' title='".$htArray['text']."'></span>";
        }
        if ($elem->getOption("unit")) $rowOption[]=$elem->getOption("unit");
        if ($elem->getOption("converting")) {
        	$htArray=$elem->getOption("converting");
        	$rowOption[]="<span class='btConverting' method='".$htArray['method']."' field='".$elem->getName()."'></span>";
        }
        //***************************
        if ($elem->getAttribute('type')!='hidden')
            $html="<div class='iRow'><span class='iLabel'>".$label."</span><span class='iInput'>".$element.implode("",$rowOption)."</span><span class='iError'>".$error."</span></div>";
        else
            $html=$element;
        return $html;
    }
    
    /**
     * Helper pour les label
     * @return FormLabel
     */
    public function getLabelHelper()
    {
    	if ($this->labelHelper) {
    		return $this->labelHelper;
    	}
    
    	if (method_exists($this->view, 'plugin')) {
    		$this->labelHelper=$this->view->plugin('form_label');
    	}
    
    	if (!$this->labelHelper instanceof FormLabel) {
    		$this->labelHelper = new FormLabel();
    	}
    	return $this->labelHelper;
    }
    
    /**
     * Helper pour les �l�ments
     */
    public function getElementHelper()
    {
        if ($this->elementHelper) {
            return $this->elementHelper;
        }
        
        if (method_exists($this->view, 'plugin')) {
            $this->elementHelper=$this->view->plugin('form_element');
        }
        
        if (!$this->elementHelper instanceof FormElement) {
        	$this->elementHelper = new FormElement();
        }
        return $this->elementHelper;
    }
    
    /**
     * Helper pour les erreur sur les �l�ments
     */
    public function getElementErrorHelper()
    {
    	if ($this->elementErrorHelper) {
    		return $this->elementErrorHelper;
    	}
    
    	if (method_exists($this->view, 'plugin')) {
    		$this->elementErrorHelper=$this->view->plugin('form_element_errors');
    	}
    
    	if (!$this->elementErrorHelper instanceof FormElementErrors) {
    		$this->elementErrorHelper = new FormElementErrors();
    	}
    	return $this->elementErrorHelper;
    }
}
