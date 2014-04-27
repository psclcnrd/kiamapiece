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
						'Search\Controller\Pieces' => 'Search\Controller\PiecesController' 
				) 
		),
		'view_manager' => array (
				'display_not_found_reason' => true,
				'display_exceptions' => true,
				'doctype' => 'HTML5',
				'template_map' => array (
						'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
						'content/header' => __DIR__ . '/../view/content/header.phtml',
						'content/footer' => __DIR__ . '/../view/content/footer.phtml',
						'content/mainmenu' => __DIR__ . '/../view/content/mainmenu.phtml',
						'search/pieces/index' => __DIR__ . '/../view/search/pieces/index.phtml',
						'search/pieces/list' => __DIR__ . '/../view/search/pieces/list.phtml',
						'search/pieces/view' => __DIR__ . '/../view/search/pieces/view.phtml', 
				),
				'template_path_stack' => array (
						'search' => __DIR__ . '/../view' 
				),
				'strategies' => array('ViewJsonStrategy') 
		),
		'router' => array (
				'routes' => array (
						'search' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/search',
										'defaults' => array (
												'__NAMESPACE__' => 'Search\Controller',
												'controller' => 'Pieces',
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
										'view' => array (
												'type' => 'Segment',
												'options' => array (
														'route' => '/view/:id',
														'constraints' => array (
																'id' => '[1..9][0..9]*' 
														),
														'defaults' => array (
																'action' => 'view' 
														) 
												),
												'verb' => 'get,post' 
										) 
								) 
						),
						'login' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/login',
										'defaults' => array (
												'__NAMESPACE__' => 'Search\Controller',
												'controller' => 'Pieces',
												'action' => 'login' 
										) 
								),
								'verb' => 'get',
								'may_terminate' => true 
						) 
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
		'service_manager' => array (
				/*'factories' => array (           Un translateur est déjà déclarer dans le MVC
						'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory' 
				) */
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
		) 
);
