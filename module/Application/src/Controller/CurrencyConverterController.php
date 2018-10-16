<?php
namespace Application\Controller;

use GrzegorzDrozd\CurrencyConverter\ConversionForm;
use GrzegorzDrozd\CurrencyConverter\CurrencyConverterService;
use Zend\Log\Logger;
use Zend\Log\LoggerAwareInterface;
use Zend\Log\LoggerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * 
 * @package Application\Controller
 */
class CurrencyConverterController extends AbstractActionController implements LoggerAwareInterface {

    /**
     * @var CurrencyConverterService
     */
    protected $currencyConverter;

    /**
     * @var ConversionForm
     */
    protected $form;

    /**
     * @var \Zend\Log\LoggerInterface
     */
    protected $logger;

    /**
     * IndexController constructor.
     * @param CurrencyConverterService $converterService
     */
    public function __construct(CurrencyConverterService $converterService, ConversionForm $form) {
        $this->setCurrencyConverter($converterService);
        
        $this->setForm($form);
    }

    /**
     * Main page view.
     *
     * Displays form and handles UI.
     *
     * @return \Zend\View\Model\ModelInterface
     */
    public function indexAction(): \Zend\View\Model\ModelInterface {
        return new ViewModel(['form'=>$this->getForm()]);
    }

    /**
     * Convert currency
     *
     * Ajax call. It does actual conversion.
     *
     * @return \Zend\View\Model\ModelInterface
     */
    public function convertAction(): \Zend\View\Model\ModelInterface {

        // check if we have correct amount
        $amount = $this->params()->fromQuery('amount', 0);
        if (empty($amount)) {
            $this->getLogger()->debug('empty amount');
            return new JsonModel(['message'=>'Please provide amount to convert']);
        }

        try {
            // do conversion
            $rate = $this->getCurrencyConverter()->convert('PLN', 'RUB');
            $ret = [
                'converted' => $rate * ((float)$amount),
                'rate'      => $rate,
                'message'   => 'OK',
            ];

        } catch (\Exception $e) {
            $this->getLogger()->err($e->getMessage(), ['e'=>$e]);
            return new JsonModel(['message'=>'Unable to convert. Please try again later']);
        }

        return new JsonModel($ret);
    }

    /**
     * @return CurrencyConverterService
     */
    public function getCurrencyConverter(): CurrencyConverterService {
        return $this->currencyConverter;
    }

    /**
     * @param CurrencyConverterService $currencyConverter
     */
    protected function setCurrencyConverter(CurrencyConverterService $currencyConverter): void {
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * @return Logger
     */
    protected function getLogger(): LoggerInterface {
        return $this->logger;
    }

    /**
     * @param \Zend\Log\LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void {
        $this->logger = $logger;
    }

    /**
     * @return ConversionForm
     */
    protected function getForm(): ConversionForm {
        return $this->form;
    }

    /**
     * @param ConversionForm $form
     */
    protected function setForm(ConversionForm $form): void {
        $this->form = $form;
    }
}
