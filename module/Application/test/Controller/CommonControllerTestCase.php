<?php
namespace ApplicationTest\Controller;

use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Base test case for almost all controllers. It sets up some basic config.
 *
 * @package ApplicationTest\Controller
 */
class CommonControllerTestCase extends AbstractHttpControllerTestCase {

    /**
     * Common setUp for all controller tests
     */
    public function setUp() {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [
            'allowOverride'=>true,
        ];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();
    }
}
