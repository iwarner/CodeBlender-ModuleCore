<?php

/**
 * CodeBlender
 *
 * @category  CodeBlender
 * @package   Core
 * @copyright Copyright (c) 2011 Triangle Solutions Ltd. (http://www.triangle-solutions.com/)
 * @license   http://codeblender.net/license
 */

/**
 * Controller
 *
 * @category  CodeBlender
 * @package   Core
 * @copyright Copyright (c) 2011 Triangle Solutions Ltd. (http://www.triangle-solutions.com/)
 * @license   http://codeblender.net/license
 *
 * @todo Errors should direct to a 404 script
 */
class Core_ErrorController extends Zend_Controller_Action
{

    /**
     * Action to create the data for the Error View
     *
     * @return void
     */
    public function errorAction()
    {
        // Get the error object
        $errors = $this->_getParam('error_handler');

        // Get the type of the error and route accordingly.
        switch ($errors->type) {

            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page Not Found';

                break;

            default:

                // Application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }

        if ($log = $this->getLog()) {
            $log->crit($this->view->message . ':' . $errors->exception);
        }

        // Conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }

        $this->view->request = $errors->request;
    }

    private function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');

        if (!$bootstrap->hasPluginResource('log')) {
            return false;
        }

        $log = $bootstrap->getResource('log');
        return $log;
    }

}
