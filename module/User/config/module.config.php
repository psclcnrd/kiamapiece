<?php

/**
 * Configuration principale des utilisateurs.
 * 
 * @author CONRAD Pascal
 * @version 1.0 03/05/2014
 */

namespace User;

return array (
		'controllers' => array (
				'invokables' => array (
						'User\Controller\User' => 'User\Controller\UserController', 
						'User\Controller\Json' => 'User\Controller\JsonController',
						'User\Controller\Adr'  => 'User\Controller\AdrController'
				) 
		),
		'router' => array (
				'routes' => array (
						'user' => array (
								'type' => 'Literal',
								'options' => array (
										// Change this to something specific to your module
										'route' => '/user',
										'defaults' => array (
												// Change this value to reflect the namespace in which
												// the controllers for your module are found
												'__NAMESPACE__' => 'User\Controller',
												'controller' => 'User',
												'action' => 'index' 
										) 
								),
								'may_terminate' => true,
								'child_routes' => array (
										'add' => array (
												'type' => 'Literal',
												'options' => array (
														'route' => '/add',
														'defaults' => array (
																'action' => 'add' 
														) 
												),
												'verb' => 'get,post' 
										),
										'view' => array (
												'type' => 'Literal',
												'options' => array (
														'route' => '/view',
														'defaults' => array (
																'action' => 'view'
														)
												),
												'verb' => 'get,post'
										),										
										'edit' => array (
												'type' => 'Segment',
												'options' => array (
														'route' => '/edit[/:id]',
														'constraints' => array (
																'id' => '[1-9][0-9]*' 
														),
														'defaults' => array (
																'action' => 'edit' 
														) 
												),
												'verb' => 'get,post' 
										),
										'pwd' => array (
												'type' => 'Segment',
												'options' => array (
														'route' => '/pwd/:id',
														'constraints' => array (
																'id' => '[1-9][0-9]*'
														),
														'defaults' => array (
																'action' => 'pwd'
														)
												),
												'verb' => 'get,post'
										),
										'lostpwd' => array (
												'type' => 'Literal',
												'options' => array (
														'route' => '/lostpwd',
														'defaults' => array (
																'action' => 'lostpwd'
														)
												),
												'verb' => 'get,post'
										),
										'validpwd' => array (
												'type' => 'Segment',
												'options' => array (
														'route' => '/validpwd/:ctrl',
														'constraints' => array (
																'ctrl' => '[A-Fa-f0-9]*'
														),
														'defaults' => array (
																'action' => 'validpwd'
														)
												),
												'verb' => 'get,post'
										),
										'login' => array (
												'type' => 'Literal',
												'options' => array (
														'route' => '/login',
														'defaults' => array (
																'action' => 'login' 
														) 
												),
												'verb' => 'get,post'
										),
										'logout' => array (
												'type' => 'Literal',
												'options' => array (
														'route' => '/logout',
														'defaults' => array (
																'action' => 'logout'
														)
												),
												'verb' => 'get,post'
										),										
										'towns' => array (
												'type' => 'Literal',
												'options' => array (
														'route' => '/towns',
														'defaults' => array (
																'__NAMESPACE__' => 'User\Controller',
																'controller' => 'Json',																
																'action' => 'towns'
														)
												),
												'verb' => 'get,post'
										),
										'verifmail' => array (
												'type' => 'Literal',
												'options' => array (
														'route' => '/verifmail',
														'defaults' => array (
																'__NAMESPACE__' => 'User\Controller',
																'controller' => 'Json',
																'action' => 'verifmail'
														)
												),
												'verb' => 'get,post'
										),
										'verifpseudo' => array (
												'type' => 'Literal',
												'options' => array (
														'route' => '/verifpseudo',
														'defaults' => array (
																'__NAMESPACE__' => 'User\Controller',
																'controller' => 'Json',
																'action' => 'verifpseudo'
														)
												),
												'verb' => 'get,post'
										),										
										'validate' => array (
												'type' => 'Segment',
												'options' => array (
														'route' => '/validate/:ctrl',
														'constraints' => array (
																'ctrl' => '[A-Fa-f0-9]*'
														),
														'defaults' => array (
																'__NAMESPACE__' => 'User\Controller',
																'controller' => 'User',
																'action' => 'validate'
														)
												),
												'verb' => 'get,post'
										),
										'mnt' => array (
												'type' => 'Literal',
												'options' => array (
														'route' => '/mnt',
														'defaults' => array (
																'__NAMESPACE__' => 'User\Controller',
																'controller' => 'User',
																'action' => 'mnt'
														)
												),
												'verb' => 'get,post'
										)										
								)
								 
						),
						'adr' => array (
								'type' => 'Literal',
								'options' => array (
										// Change this to something specific to your module
										'route' => '/adr',
										'defaults' => array (
												// Change this value to reflect the namespace in which
												// the controllers for your module are found
												'__NAMESPACE__' => 'User\Controller',
												'controller' => 'Adr',
												'action' => 'index'
										)
								),
								'may_terminate' => true,
								'child_routes' => array (
										'add' => array (
												'type' => 'Literal',
												'options' => array (
														'route' => '/add',
														'defaults' => array (
																'action' => 'add'
														)
												),
												'verb' => 'get,post'
										),
										'edit' => array (
												'type' => 'Segment',
												'options' => array (
														'route' => '/edit/:id',
														'constraints' => array (
																'id' => '[1-9][0-9]*'
														),
														'defaults' => array (
																'action' => 'edit'
														)
												),
												'verb' => 'get,post'
										),

								)
									
						)
				) 
		),
		'view_manager' => array (
				'display_not_found_reason' => true,
				'display_exceptions' => true,
				'doctype' => 'HTML5',
				'template_map' => array (
						'user/edit_user' => __DIR__ . '/../view/user/user/edit_user.phtml',
						'user/edit_adr' => __DIR__ . '/../view/user/user/edit_adr.phtml',
						'user/edit_pwd' => __DIR__ . '/../view/user/user/edit_pwd.phtml',
						'user/lost_pwd' => __DIR__ . '/../view/user/user/lost_pwd.phtml',
						'user/lost_pwd2' => __DIR__ . '/../view/user/user/lost_pwd2.phtml',
				),
				'template_path_stack' => array (
						'User' => __DIR__ . '/../view'
				)
		),
		'strategies' => array('ViewJsonStrategy'),
		'doctrine' => array (
				'driver' => array (
						__NAMESPACE__ . '_driver' => array (
								'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
								'cache' => 'array',
								'paths' => array (
										__DIR__ . '/../src/' . __NAMESPACE__ . '/Model',
										__DIR__ . '/../../Search/src/Search/Models' 
								) 
						),
						'orm_default' => array (
								'drivers' => array (
										__NAMESPACE__ . '\Model' => __NAMESPACE__ . '_driver' 
								) 
						) 
				) 
		),
		'service_manager' => array (
				'factories' => array (
						'User\Service\Users' => 'User\Service\Factory\UsersServiceFactory',
						'User\Service\Addresses' => 'User\Service\Factory\AddressesServiceFactory',
				) 
		),
		'translator' => array (
				'locale' => 'fr_FR',
				'translation_file_patterns' => array (
						array (
								'type' => 'gettext',
								'base_dir' => __DIR__ . '/../language',
								'pattern' => '%s.mo',
								'text_domain' => 'user' 
						) 
				) 
		) 
);
