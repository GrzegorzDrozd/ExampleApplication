<?php
namespace Application\Factory;

use Application\Controller\CurrencyConverterController;
use Interop\Container\ContainerInterface;
use Zend\Log\LoggerAwareInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

/**
 * Common factory for all controllers
 */
class CommonControllerFactory implements AbstractFactoryInterface {

    /**
     * Can the factory create an instance for the service?
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName): bool {
        return $container->get('Di')->has($requestedName);
    }

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

        /** @var AbstractActionController $controller */
        $controller = $container->get('Di')->get($requestedName, (array)$options);

        if ($controller instanceof LoggerAwareInterface) {
            $controller->setLogger($container->get(\Zend\Log\Logger::class));
        }

        return $controller;
    }
}
