<?php

namespace Message;

return array(
    'controllers' => array(
        'invokables' => array(
            'Message\Controller\Message' => 'Message\Controller\MessageController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'message' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/message',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Message\Controller',
                        'controller'    => 'Message',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'add' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/add/:pieceId',
                        	'constraints' => array(
                        			'pieceId' => '[A-Za-z0-9]*'
                             ),
                            'defaults' => array(
                            		'action' => 'add'
                            ),
                        ),
                    	'verb' => 'get,post'
                    ),
                	'view' => array(
                			'type' => 'Segment',
                			'options' => array(
                					'route' => '/view/:id',
                					'contraints' => array(
                							'id' => '[A-Za-z0-9]*'
                					),
                					'defaults' => array(
                							'action' => 'view'
                				)
                			),
                			'verb' => 'get,post'
                	),
                	'respond' => array(
                			'type' => 'Segment',
                			'options' => array(
                					'route' => '/respond/:id',
                					'contraints' => array(
                							'id' => '[A-Za-z0-9]*'
                					),
                					'defaults' => array(
                							'action' => 'respond'
                					)
                			),
                			'verb' => 'get,post'
                	),                		
                	'list' => array(
                		'type'    => 'Literal',
                		'options' => array(
                				'route'    => '/list',
                				'defaults' => array(
                						'action' => 'list'
                				),
                		),
                		'verb' => 'get,post'
                	),
                ),
            ),
        ),
    ),
    'view_manager' => array(
    	'display_not_found_reason' => true,
    	'display_exceptions' => true,
    	'doctype' => 'HTML5',
    	'template_map' => array (
    				'message/edit' => __DIR__ . '/../view/message/message/edit.phtml',
    				'message/list' => __DIR__ . '/../view/message/message/list.phtml',
    				'message/view' => __DIR__ . '/../view/message/message/view.phtml',
    				),
        'template_path_stack' => array(
            'Message' => __DIR__ . '/../view',
        ),
    ),
	'service_manager' => array(
        	'factories' => array(
				'Message\Service\Messages' => 'Message\Service\Factory\MessagesServiceFactory',
		)
    ),
		'translator' => array (
				'locale' => 'fr_FR',
				'translation_file_patterns' => array (
						array (
								'type' => 'gettext',
								'base_dir' => __DIR__ . '/../language',
								'pattern' => '%s.mo',
								'text_domain' => 'message'
						)
				)
		),
);
