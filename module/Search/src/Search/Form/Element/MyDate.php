<?php

namespace Search\Form\Element;

use Zend\Form\Element;

/**
 *
 * @author Pascal CONRAD
 *        
 */
class MyDate extends Element
{
    
    protected $attributes = array(
        'type' => 'mydate',
        'jqtype' => 'date'
    );
}

?>