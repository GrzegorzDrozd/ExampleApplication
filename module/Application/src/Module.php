<?php
namespace Application;

/**
 * Module configuration
 * 
 * @package Application
 */
class Module
{
    const VERSION = '3.0.3-dev';

    /**
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function onBootstrap(\Zend\Mvc\MvcEvent $e)
    {

        /** @var \Zend\Mvc\Application $app */
        $app = $e->getTarget();

        /** @var \Zend\ServiceManager\ServiceManager $services */
        $services = $app->getServiceManager();

        // register zend Di as a factory.
        $services->setFactory(Di\ConfigInterface::class, Container\ConfigFactory::class);
        $services->setFactory(Di\InjectorInterface::class, Container\InjectorFactory::class);
    }

    /**
     * Get config for a module.
     *
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
