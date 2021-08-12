<?php

declare(strict_types=1);

namespace Application;

use Application\Controller\HyperlinkController;
use Application\Controller\SectionController;
use Application\Form\HyperlinkForm;
use Application\Form\Factory\HyperlinkFormFactory;
use Application\Service\Factory\HyperlinkModelAdapterFactory;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'links' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/links',
                    'defaults' => [
                        'controller' => HyperlinkController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => TRUE,
                'child_routes' => [
                    'default' => [
                        'type' => Segment::class,
                        'priority' => -100,
                        'options' => [
                            'route' => '/[:action[/:uuid]]',
                            'defaults' => [
                                'action' => 'index',
                                'controller' => HyperlinkController::class,
                            ],
                        ],
                    ],
                ],
            ],
            'sections' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/sections',
                    'defaults' => [
                        'controller' => SectionController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => TRUE,
                'child_routes' => [
                    'default' => [
                        'type' => Segment::class,
                        'priority' => -100,
                        'options' => [
                            'route' => '/[:action[/:uuid]]',
                            'defaults' => [
                                'action' => 'index',
                                'controller' => SectionController::class,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'acl' => [
        'EVERYONE' => [
            'home' => ['index'],
        ],
        'admin' => [
            'links' => [],
            'links/default' => [],
            'links/config' => [],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\HyperlinkController::class => Controller\Factory\HyperlinkControllerFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            HyperlinkForm::class => HyperlinkFormFactory::class,
        ],
    ],
    'navigation' => [
        'default' => [
            'home' => [
                'label' => 'Home',
                'route' => 'home',
                'order' => 0,
            ],
            'links' => [
                'label' => 'Links',
                'route' => 'links',
                'class' => 'dropdown',
                'resource' => 'links/default',
                'privilege' => 'menu',
                'pages' => [
                    [
                        'label' => 'Add New Link',
                        'route' => 'links/default',
                        'action' => 'create',
                        'resource' => 'links/default',
                        'privilege' => 'create',
                    ],
                    [
                        'label' => 'View Links',
                        'route' => 'links/default',
                        'action' => 'index',
                        'resource' => 'links/default',
                        'privilege' => 'index',
                    ],
                ],
            ],
            'sections' => [
                'label' => 'Sections',
                'route' => 'sections',
                'class' => 'dropdown',
                'resource' => 'sections/default',
                'privilege' => 'create',
                'pages' => [
                    [
                        'label' => 'Add New Section',
                        'route' => 'sections/default',
                        'action' => 'create',
                        'resource' => 'sections/default',
                        'privilege' => 'create',
                    ],
                    [
                        'label' => 'View Sections',
                        'route' => 'sections/default',
                        'action' => 'index',
                        'resource' => 'sections/default',
                        'privilege' => 'create',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'hyperlink-model-adapter-config' => 'model-adapter-config',
        ],
        'factories' => [
            'hyperlink-model-adapter' => HyperlinkModelAdapterFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../../User/view/layout/user-layout.phtml',
            'layout/metromega'        => __DIR__ . '/../view/layout/metromega.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'navigation'              => __DIR__ . '/../view/partials/navigation.phtml',
            'flashmessenger'          => __DIR__ . '/../view/partials/flashmessenger.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
