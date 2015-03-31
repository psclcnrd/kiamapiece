<?php

namespace Request; 

return array(
    'controllers' => array(
        'invokables' => array(
            'Request\Controller\Request' => 'Request\Controller\RequestController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'request' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/request',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Request\Controller',
                        'controller'    => 'Request',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'do' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/do/:id',
                            'constraints' => array(
                                'id' => '[a-zA-Z0-9][a-zA-Z0-9]*',
                            ),
                            'defaults' => array(
                            		'action' => 'do'
                            ),
                        	'verb' => 'get,post'
                        ),
                    ),
					'receive' => array(
                				'type'    => 'Segment',
                				'options' => array(
                						'route'    => '/receive/:id',
                						'constraints' => array(
                								'id' => '[a-zA-Z0-9][a-zA-Z0-9]*',
                						),
                						'defaults' => array(
                								'action' => 'receive'
                						),
                						'verb' => 'get,post'
                				),
                		),
                		'del' => array(
                				'type'    => 'Segment',
                				'options' => array(
                						'route'    => '/del/:id',
                						'constraints' => array(
                								'id' => '[a-zA-Z0-9][a-zA-Z0-9]*',
                						),
                						'defaults' => array(
                								'action' => 'del'
                						),
                						'verb' => 'get,post'
                				),
                		),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Request' => __DIR__ . '/../view',
        ),
    ),
	'service_manager' => array(
        	'factories' => array(
					'Request\Service\Request' => 'Request\Service\Factory\RequestsServiceFactory'
	        )
        )
);
