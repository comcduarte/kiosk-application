<?php

declare(strict_types=1);

namespace Application;

use Application\Controller\HyperlinkController;
use Application\Controller\NewsController;
use Application\Controller\SectionController;
use Application\Form\HyperlinkForm;
use Application\Form\NewsForm;
use Application\Form\SectionForm;
use Application\Form\Factory\HyperlinkFormFactory;
use Application\Form\Factory\NewsFormFactory;
use Application\Form\Factory\SectionFormFactory;
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
                    'route'    => '/application',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'config' => [
                        'type' => Segment::class,
                        'priority' => 100,
                        'options' => [
                            'route' => '/config[/:action]',
                            'defaults' => [
                                'action' => 'index',
                                'controller' => Controller\ApplicationConfigController::class,
                            ],
                        ],
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
            'news' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/news',
                    'defaults' => [
                        'controller' => NewsController::class,
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
                                'controller' => NewsController::class,
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
            'sections' => [],
            'sections/default' => [],
            'sections/config' => [],
            'news' => [],
            'news/default' => [],
            'news/config' => [],
            'application/config' => [],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ApplicationConfigController::class => Controller\Factory\ApplicationConfigControllerFactory::class,
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
            Controller\HyperlinkController::class => Controller\Factory\HyperlinkControllerFactory::class,
            Controller\NewsController::class => Controller\Factory\NewsControllerFactory::class,
            Controller\SectionController::class => Controller\Factory\SectionControllerFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            HyperlinkForm::class => HyperlinkFormFactory::class,
            NewsForm::class => NewsFormFactory::class,
            SectionForm::class => SectionFormFactory::class,
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
            'news' => [
                'label' => 'News',
                'route' => 'news',
                'class' => 'dropdown',
                'resource' => 'news/default',
                'privilege' => 'create',
                'pages' => [
                    [
                        'label' => 'Add New Section',
                        'route' => 'news/default',
                        'action' => 'create',
                        'resource' => 'news/default',
                        'privilege' => 'create',
                    ],
                    [
                        'label' => 'View News',
                        'route' => 'news/default',
                        'action' => 'index',
                        'resource' => 'news/default',
                        'privilege' => 'create',
                    ],
                ],
            ],
            'settings' => [
                'pages' => [
                    'application' => [
                        'label' => 'Application Settings',
                        'route' => 'application/config',
                        'action' => 'index',
                        'resource' => 'application/config',
                        'privilege' => 'index',
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
    'view_helpers' => [
        'aliases' => [
            'functions' => View\Helper\Functions::class,
        ],
        'factories' => [
            View\Helper\Functions::class => InvokableFactory::class,
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
            'currentflashmessenger'          => __DIR__ . '/../view/partials/currentflashmessenger.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
