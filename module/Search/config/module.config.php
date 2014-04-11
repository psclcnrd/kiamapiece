<?php

/**
 * Fichier de configurtion du module.
 * Ne remonte d'un tableau contenant toutes la configuration du module
 * @author CONRAD Pascal
 * @version 1.0 11/04/2014
 * 
 * La route /search amène vers la première liste des éléments les derniers rentrés
 */
return array (
		'controllers' => array (
				'invokables' => array (
						'Search\Controller\Pieces' => 'Search\Controller\PiecesController' 
				) 
		),
		'view_manager' => array (
				'template_map' => array (
						'search/pieces/list' => __DIR__ . '/../view/search/pieces/list.phtml',
						'search/pieces/view' => __DIR__ . '/../view/search/pieces/view.phtml',
						'search/pieces/xsearch' => __DIR__ . '/..view/search/pieces/xsearch.phtml' 
				),
				'template_path_stack' => array (
						'search' => __DIR__ . '/../view' 
				) 
		),
		'routers' => array (
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
								'may_terminate' => true 
						) ,
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
								'type' => 'Literal',
								'options' => array (
										'route' => '/view/:id',
										'constraints' => array('id' => '[1..9][0..9]*'),
										'defaults' => array (
												'action' => 'view'
										)
								),
								'verb' => 'get,post'
						)
				) 
		) 
);

?>