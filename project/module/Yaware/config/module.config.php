<?php
namespace Yaware;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
		'router' => [
			'routes' => [
				'home' => [
						'type' => Literal::class,
						'options' => [
									'route'    => '/',
									'defaults' => [
												'controller' => Controller\UserController::class,
												'action'     => 'index',
									],
						],
				],
				'user' => [
						'type'    => Segment::class,
						'options' => [
									'route' => '/user[/:action[/:id]]',
									'constraints' => [
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										],
									'defaults' => [
												'controller' => Controller\UserController::class,
												'action'     => 'index',
									],
							],
				],
			],
		],
		
		
		'view_manager' => [
				'template_path_stack' => [
						'yaware' => __DIR__ . '/../view',
				],
		],
];
