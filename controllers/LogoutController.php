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
 */
class Core_LogoutController extends Zend_Controller_Action
{

    /**
     * Action
     */
    public function indexAction()
    {
        // Set the script to not render to any view
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        // Clear the identity and redirect to the Index page
        Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session(CODEBLENDER_SITENAME))->clearIdentity();

        // Redirect the user accordingly
        $this->_helper->getHelper('Redirector')->gotoUrl('index');
    }

}
