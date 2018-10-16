<?php
namespace ApplicationTest\Controller;

use Application\Controller\IndexController;

/**
 * Check if main page works ok.
 * 
 * @package ApplicationTest\Controller
 */
class IndexControllerTest extends CommonControllerTestCase {

    /**
     * Check if main page of the application can be viewed
     *
     * @throws \Exception
     */
    public function testIndexActionCanBeAccessed() {
        $this->dispatch('/', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('home');
    }

    /**
     * Check rendered page
     *
     * @throws \Exception
     */
    public function testIndexActionViewModelTemplateRenderedWithinLayout() {
        $this->dispatch('/', 'GET');
        $this->assertQuery('.container .jumbotron');
    }

    /**
     * Test if 404 page returns correct response code
     *
     * @throws \Exception
     */
    public function testInvalidRouteDoesNotCrash() {
        $this->dispatch('/invalid/route', 'GET');
        $this->assertResponseStatusCode(404);
    }
}
