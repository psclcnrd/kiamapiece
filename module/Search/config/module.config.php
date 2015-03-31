<?php

namespace Search;

/**
 * Fichier de configuration du module.
 * Ne remonte qu'un tableau contenant toute la configuration du module
 *
 * @author CONRAD Pascal
 * @version 1.0 11/04/2014
 *         
 */
return array (
		'controllers' => array (
				'invokables' => array (
						'Search\Controller\Search' => 'Search\Controller\SearchController' 
				) 
		),
		'view_manager' => array (
				'display_not_found_reason' 	=> true,
				'display_exceptions' 		=> true,
				'not_found_template'       	=> 'error/404',
				'exception_template'       	=> 'error/index',
				'doctype' 					=> 'HTML5',
				'template_map' => array (
						'layout/layout' 		=> __DIR__ . '/../view/layout/layout.phtml',
						'content/header' 		=> __DIR__ . '/../view/content/header.phtml',
						'content/footer' 		=> __DIR__ . '/../view/content/footer.phtml',
						'content/mainmenu' 		=> __DIR__ . '/../view/content/mainmenu.phtml',
						'search/pieces/index' 	=> __DIR__ . '/../view/search/pieces/index.phtml',
						'search/pieces/list' 	=> __DIR__ . '/../view/search/pieces/list.phtml',
						'error/nologin'			=> __DIR__ . '/../view/error/nologin.phtml',
						'error/404'				=> __DIR__ . '/../view/error/404.phtml',
						'error/index'           => __DIR__ . '/../view/error/exception.phtml',
				),
				'template_path_stack' => array (
						'search' => __DIR__ . '/../view' 
				),
				'strategies' => array('ViewJsonStrategy') 
		),
		'router' => array (
				'routes' => array (
						'home' => array(
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array(
										'route'    => '/',
										'defaults' => array(
												'controller' => 'Search\Controller\Search',
												'action'     => 'index',
										),
								),
						),
						'search' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/search',
										'defaults' => array (
												'__NAMESPACE__' => 'Search\Controller',
												'controller' => 'Search',
												'action' => 'index' 
										) 
								),
								'verb' => 'get',
								'may_terminate' => true,
								'child_routes' => array (
										'list' => array (
												'type' => 'Literal',
												'options' => array (
														'route' => '/list',
														'defaults' => array (
																'action' => 'list' 
														) 
												),
												'verb' => 'get,post' 
										),
										'nav' => array (
												'type' => 'Segment',
												'options' => array (
														'route' => '/nav/:page',
														'constraints' => array (
																'page' => '[1-9][0-9]*'
														),
														'defaults' => array (
																'action' => 'nav'
														)
												),
												'verb' => 'get,post'
										)										
								) 
						),
				) 
		),
		'doctrine' => array (
				'driver' => array (
						__NAMESPACE__ . '_driver' => array (
								'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
								'cache' => 'array',
								'paths' => array (
										__DIR__ . '/../src/' . __NAMESPACE__ . '/Models' 
								) 
						),
						'orm_default' => array (
								'drivers' => array (
										__NAMESPACE__ . '\Models' => __NAMESPACE__ . '_driver' 
								) 
						) 
				) 
		),
		'view_helpers' => array(
				'invokables' => array(
						'MyFormRow' => 'Search\Form\View\Helper\MyFormRow',
						'MyFormSelect' => 'Search\Form\View\Helper\MyFormSelect',
				)
		),
		'service_manager' => array(
						'abstract_factories' => array(
								'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
								'Zend\Log\LoggerAbstractServiceFactory',
						),
						'aliases' => array(
								'translator' => 'MvcTranslator',
						),						
		),		
		'translator' => array (
				'locale' => 'fr_FR',
				'translation_file_patterns' => array (
						array (
								'type' => 'gettext',
								'base_dir' => __DIR__ . '/../language',
								'pattern' => '%s.mo',
								'text_domain' => 'search' 
						) 
				) 
		),
		'search_module' => array(
			'line_per_page' => 15
		),
		'smtp_options' => array(
    					'name' => 'ovh.net',
    					'host' => 'ssl0.ovh.net',
    					'port' => 465,
    					'connection_class' => 'login',
    					'connection_config' => array(
    							'username' => 'admin@kiamapiece.fr',
    							'password' => 'Du4BlieWnal',
    							'ssl' => 'ssl',
    					)
    	)
);
