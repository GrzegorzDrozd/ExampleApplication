<?php
namespace Application\Factory;

use Application\Controller\CurrencyConverterController;
use Interop\Container\ContainerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Common factory for all controllers
 */
class CurrencyConverterControllerFactory implements FactoryInterface {

    /**
     * Create object from $requestedName.
     *
     * It uses DI under the hood to resolve dependencies from object constructor.
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return AbstractActionController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): AbstractActionController {

        // get current config
        $config = $container->get('config');

        // get controller instance
        /** @var CurrencyConverterController $controller */
        $controller = $container->get('Di')->get(CurrencyConverterController::class);

        // get auto created converter and set api key to use.
        $controller->getCurrencyConverter()->setApiKey($config['currency_converter']['forge']['key']);

        // set logger
        $controller->setLogger($container->get(\Zend\Log\Logger::class));

        return $controller;
    }
}
