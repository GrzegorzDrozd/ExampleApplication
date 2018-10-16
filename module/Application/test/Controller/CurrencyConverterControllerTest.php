<?php
namespace ApplicationTest\Controller;

use Application\Controller\CurrencyConverterController;
use GrzegorzDrozd\CurrencyConverter\CurrencyConverterService;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class CurrencyConverterControllerTest extends CommonControllerTestCase {

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|CurrencyConverterService
     */
    protected $currencyConvertedServiceMock;

    /**
     * Main set up
     *
     * Prepare currency converter mock and store it in a container.
     */
    public function setUp() {
        parent::setUp();

        // prepare mock for conversion service
        $this->currencyConvertedServiceMock = $this
            ->getMockBuilder(CurrencyConverterService::class)
            ->disableOriginalConstructor()
            ->setMethods(['convert'])
            ->getMock();

        // get service manager and di to set mock in place of a real object
        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);

        /** @var \Zend\Di\Di $di */
        $di = $serviceManager->get('Di');
        // set mock in place of a real object.
        $di->instanceManager()->addSharedInstance($this->currencyConvertedServiceMock, CurrencyConverterService::class);
    }

    /**
     * Test main currency converter page
     *
     * @throws \Exception
     */
    public function testIndexActionCanBeAccessed() {
        $this->dispatch('/currency_converter', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(CurrencyConverterController::class); // as specified in router's controller name alias
        $this->assertControllerClass('CurrencyConverterController');
        $this->assertMatchedRouteName('currency_converter');
    }

    /**
     * Test conversion endpoint. This returns json response.
     *
     * @throws \Exception
     */
    public function testConvertActionCanBeAccessed() {
        $this->dispatch('/currency_converter/convert', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(CurrencyConverterController::class); // as specified in router's controller name alias
        $this->assertControllerClass('CurrencyConverterController');
        $this->assertMatchedRouteName('currency_converter_convert');
        $this->assertResponseHeaderRegex('Content-Type', '/json/ims');
    }

    /**
     * Test basic conversion
     *
     * @throws \Exception
     */
    public function testBasicConversion()  {

        $this->currencyConvertedServiceMock->expects(self::any())->method('convert')->willReturn(1);


        $this->dispatch('/currency_converter/convert?amount=100', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertResponseHeaderRegex('Content-Type', '/json/ims');
        
        $responseContent = $this->getResponse()->getContent();

        $responseContentParsed = json_decode($responseContent, true);

        self::assertSame(JSON_ERROR_NONE, json_last_error());
        self::assertSame(100,   $responseContentParsed['converted']);
        self::assertSame('1',   $responseContentParsed['rate']);
        self::assertSame('OK',  $responseContentParsed['message']);
    }

    /**
     * Check if there is correct response when conversion fails
     *
     * @throws \Exception
     */
    public function testConversionException() {

        $this->currencyConvertedServiceMock->expects(self::any())->method('convert')->willThrowException(new \Exception('test message'));

        $this->dispatch('/currency_converter/convert?amount=100', 'GET');
        $this->assertResponseStatusCode(200);
        $responseContent = $this->getResponse()->getContent();

        $responseContentParsed = json_decode($responseContent, true);

        self::assertSame(JSON_ERROR_NONE, json_last_error());
        self::assertSame(
            'Unable to convert. Please try again later',
            $responseContentParsed['message']
        );
    }

}
