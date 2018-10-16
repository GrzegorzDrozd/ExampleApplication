<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @package Application\Controller
 */
class IndexController extends AbstractActionController {

    /**
     * Main page view.
     *
     * Not much here, move along.
     *
     * @return ViewModel
     */
    public function indexAction(): \Zend\View\Model\ModelInterface {
        return new ViewModel();
    }
}
