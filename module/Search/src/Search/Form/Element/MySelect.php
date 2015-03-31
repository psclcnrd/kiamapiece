<?php

namespace Search\Form\Element;

use Zend\InputFilter\InputProviderInterface;
use Zend\Form\Element;
use Doctrine\ORM\EntityManager;

/**
 *
 * Select spécifique avec un remplissage par Doctrine
 *
 * @author Pascal CONRAD
 * @version 1.0
 * @version 1.1 19/08/2014 Ajout choix valeur vide     
 */
class MySelect extends Element implements InputProviderInterface
{
    
    protected $attributes = array('type' => 'myselect');
    
    protected $useHiddenElement = false;
    
    /**
     * Entity Manager 
     * @var Doctrine\ORM\EntityManager
     */
    protected $em=null;
    
    /**
     * Nom du champ contenant la valeur
     * @var string
     */
    protected $valueField;
    
    /**
     * Nom du champ contenant le texte
     * @var unknown
     */
    protected $textField;
    
    /**
     * Entit� sur laquelle faire la req�te : Module\Model\Entity
     * @var unknown
     */
    protected $entity;
    
    /**
     * Filtre de s�lection de la liste - NON IMPLEMENTER -
     * @var unknown
     */
    protected $filter=array();
    
    /**
     * Ordre de tri des �l�ments
     * @var unknown
     */
    protected $orderBy;
    
    /**
     * Valeur si sans valeur
     * @var array Tableau associatif, avec comme cl� "id" et "text"
     */
    protected $emptyValue;
    
    /**
     * Tableau des options
     * @var array<string>
     */
    protected $valueOptions=array();

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\InputFilter\InputProviderInterface::getInputSpecification()
     *
     */
    public function getInputSpecification()
    {
        $spec = array(
        		'name' => $this->getName(),
        		'required' => true,
        );
        return $spec;    	
    }
    
    public function getValidator() {
        return null;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\Form\ElementInterface::setOption()
     *
     */
    public function setOption($key, $value)
    {
    	parent::setOption($key, $value);
    	
    	if ($key=='em') {
    	    $this->em=value;
   	    }
   	    if ($key=='valueField') {
   	    	$this->valueField=$value;
   	    }
   	    if ($key=='textField') {
   	    	$this->textField=$value;
   	    }
   	    if ($key=='entity') {
   	    	$this->entity=$value;
   	    }
   	    if ($key=="orderBy") {
   	    	$this->orderBy=$value;
   	    }
   	    if ($key=="filter") {
   	    	$this->filter=$value;
   	    }
   	    $this->valueOptions=array();   	    
   	    if ($this->em!=null) $this->setValueOptions();
    }
    
    /**
     * (non-PHPdoc)
     * @see \Zend\Form\Element::setOptions()
     */
    public function setOptions($options)
    {
        parent::setOptions($options);
        
        if (isset($options["em"])) {
            $this->em=$options["em"];
        }
        if (isset($options["valueField"])) {
        	$this->valueField=$options["valueField"];
        }
        if (isset($options["textField"])) {
        	$this->textField=$options["textField"];
        }
        if (isset($options["entity"])) {
        	$this->entity=$options["entity"];
        }
        if (isset($options["orderBy"])) {
        	$this->orderBy=$options["orderBy"];
        }        
        if (isset($options["filter"])) {
        	$this->filter=$options["filter"];
        }
        if (isset($options["emptyValue"])) {
        	$this->emptyValue=$options["emptyValue"];
        }
        $this->valueOptions=array();
        if ($this->em!=null) $this->setValueOptions();
    }

    /**
     * Initialise le tableau des options
     */
    private function setValueOptions()
    {
        if (($this->valueField!="") && ($this->textField!="")) $selector='u.'.$this->valueField.',u.'.$this->textField;else $selector='u';
        $qb=$this->em->createQueryBuilder();
        $qb->select($selector)->from($this->entity,'u');
        if ($this->orderBy!="") $qb->orderBy('u.'.$this->orderBy);
        if (count($this->filter)) {
            $qb->where('u.'.$this->filter['field'].'=?1');
            $qb->setParameter(1,$this->filter['value']);
        }
        $query=$qb->getQuery();
        $result=$query->getScalarResult();
        $allkeys=null;
        if (is_array($this->emptyValue) && (count($this->emptyValue)!=0)) {
            $key=$this->emptyValue["id"];
            $this->valueOptions["$key"]=$this->emptyValue["text"];
        }
        foreach($result as $option) {
            if ($allkeys==null) $allkeys=array_keys($option);
            $key=$option[$allkeys[0]];
            $this->valueOptions["$key"]=$option[$allkeys[1]];
        }
    }

    /**
     * Retourne le tableau des options
     * @return \Datas\Form\Element\array<string>
     */
    public function getValueOptions() {
        return $this->valueOptions;
    }

    /**
     * Retourne le champ de la cl� de la liste
     * @return string
     */
    public function getValueField() {
        return $this->valueField;
    }

    /*
    public function getValue() {
        //$r=$this->em->find($this->entity,(int) $this->value);
        error_log("passe");
        $r=$this->value;
        return $r;
    }*/
}
