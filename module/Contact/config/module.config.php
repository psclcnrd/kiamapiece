<?php

namespace Contact;

return array(
    'controllers' => array(
        'invokables' => array(
            'Contact\Controller\Contact' => 'Contact\Controller\ContactController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'contact' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/contact',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Contact\Controller',
                        'controller'    => 'Contact',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
            ),
        		'contactfree' => array(
        				'type'    => 'Literal',
        				'options' => array(
        						// Change this to something specific to your module
        						'route'    => '/contactfree',
        						'defaults' => array(
        								// Change this value to reflect the namespace in which
        								// the controllers for your module are found
        								'__NAMESPACE__' => 'Contact\Controller',
        								'controller'    => 'Contact',
        								'action'        => 'indexfree',
        						),
        				),
        				'may_terminate' => true,
        		),
        		'mention' => array(
        				'type'    => 'Literal',
        				'options' => array(
        						// Change this to something specific to your module
        						'route'    => '/mention',
        						'defaults' => array(
        								// Change this value to reflect the namespace in which
        								// the controllers for your module are found
        								'__NAMESPACE__' => 'Contact\Controller',
        								'controller'    => 'Contact',
        								'action'        => 'mention',
        						),
        				),
        				'may_terminate' => true,
        		),        		
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Contact' => __DIR__ . '/../view',
        ),
    ),
);
