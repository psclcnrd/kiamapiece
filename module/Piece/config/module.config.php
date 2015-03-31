<?php

namespace Piece;

return array(
    'controllers' => array(
        'invokables' => array(
            'Piece\Controller\Piece' => 'Piece\Controller\PieceController',
        ),
    ),
    'router' => array(
        'routes' => array(
					'pieces' => array(
							'type' => 'Literal',
							'options' => array(
											'route' => '/pieces',
											'defaults' => array (
													'__NAMESPACE__' => 'Piece\Controller',
													'controller' => 'Piece',
													'action' => 'index' 
											)
									),
									'verb' => 'get,post',
									'child_routes' => array(
										'add' => array(
												'type' => 'Literal',
												'options' => array(
														'route' => '/add',
														'defaults' => array(
															'action' => 'add'
														)
													),
													'verb' => 'get,post'
												),
										'edit' => array(
												'type' => 'Segment',
												'options' => array(
														'route' => '/edit/:id',
														'constraints' => array (
																'id' => '[1-9][0-9]*'
														),														
														'defaults' => array(
																'action' => 'edit'
														)
												),
												'verb' => 'get,post'
										),
										'view' => array (
												'type' => 'Segment',
												'options' => array (
														'route' => '/view/:id',
														'constraints' => array (
																'id' => '[1-9][0-9]*'
														),
														'defaults' => array (
																'action' => 'view'
														)
												),
												'verb' => 'get,post'
										),
										'del' => array(
												'type' => 'Segment',
												'options' => array(
														'route' => '/del/:id',
														'constraints' => array (
																'id' => '[1-9][0-9]*'
														),
														'defaults' => array(
																'action' => 'delete'
														)
												),
												'verb' => 'get,post'
										),										
									)
						)
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Piece' => __DIR__ . '/../view',
        ),
    	'template_map' => array(
    			'piece/pieces/view' 	=> __DIR__ . '/../view/piece/piece/view.phtml',
    			'piece/piece/edit' 	=> __DIR__ . '/../view/piece/piece/edit.phtml',
        )
    ),
	'service_manager' => array(
			'factories' => array(
					'Piece\Service\Pieces' => 'Piece\Service\Factory\PiecesServiceFactory',
			),
	)
);
