<?php
namespace Application;

use Application\Controller\CurrencyConverterController;
use Application\Factory\CurrencyConverterControllerFactory;
use Application\Factory\IndexControllerFactory;
use GrzegorzDrozd\CurrencyConverter\CurrencyConverterService;
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

    'currency_converter'    => [
        'forge' => [
            'key'   => 'NpQYwk5r38oRWweqlsBHTyVyUsknJr4c'
        ]
    ],

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
        'factories' => [
            CurrencyConverterController::class => function (\Interop\Container\ContainerInterface $container) {
                // get current config
                $config = $container->get('config');
                /** @var CurrencyConverterController $controller */

                // get controller instance
                $controller = $container->get('Di')->get(CurrencyConverterController::class);

                // get auto created converter and set api key to use.
                $controller->getCurrencyConverter()->setApiKey($config['currency_converter']['forge']['key']);

                // set logger
                $controller->setLogger($container->get(\Zend\Log\Logger::class));

                return $controller;
            }
        ],

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

