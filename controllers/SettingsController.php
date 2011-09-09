<?php

/**
 * CodeBlender
 *
 * @category  CodeBlender
 * @package   Core
 * @copyright Copyright (c) 2000-2011 Triangle Solutions Ltd. (http://www.triangle-solutions.com/)
 * @license   http://codeblender.net/license
 */

/**
 * Controller
 *
 * @category  CodeBlender
 * @package   Core
 * @copyright Copyright (c) 2000-2011 Triangle Solutions Ltd. (http://www.triangle-solutions.com/)
 * @license   http://codeblender.net/license
 *
 * @todo Does this work if no session or cache is available - test and fix
 */
class Core_SettingsController extends Zend_Controller_Action
{

    /**
     * Action
     */
    public function indexAction()
    {
        // Get the session
        $this->view->session = new Zend_Session_Namespace(CODEBLENDER_SITENAME);

        // Get the Auth Instance
        $auth = Zend_Auth::getInstance();

        // Check to see if this user is manager and then ascertain teams they manage
        if ($auth->hasIdentity()) {
            $this->view->credentials = $auth->getIdentity();
        }
    }

}
