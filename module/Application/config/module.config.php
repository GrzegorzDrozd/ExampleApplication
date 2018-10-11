<?php
namespace Application;

use Application\Factory\CurrencyConverterControllerFactory;
use Application\Factory\IndexControllerFactory;
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
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'currency_converter' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/currency_converter',
                    'defaults' => [
                        'controller' => Controller\CurrencyConverterController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'currency_converter_convert' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/currency_converter/convert',
                    'defaults' => [
                        'controller' => Controller\CurrencyConverterController::class,
                        'action'     => 'convert',
                    ],
                ],
            ],
        ],
    ],

//    'service_manager' => [
//        'factories' => [
//            \Zend\Log\Logger::class => function () {
//    die('ddddd');
//            }
//        ],
//    ],

    'log' => [
        'writers' => [
            'stream' => [
                'name' => 'stream',
                'options' => [
                    'stream' => 'data/php.log',
                    'formatter' => [
                        'name' => \Zend\Log\Formatter\Simple::class,
                    ],

                ],
            ],
        ],
        'processors' => [
            'requestid' => [
                'name' => \Zend\Log\Processor\RequestId::class,
            ],
        ],
    ],
    'controllers' => [
        //one factory to create them all
        'abstract_factories'=> [
            Factory\CommonControllerFactory::class
        ],
    ],

    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],

        // to enable json returns
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];

