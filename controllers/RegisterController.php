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
class Core_RegisterController extends Zend_Controller_Action
{

    /**
     * Init
     */
    public function init()
    {
        // Config
        $this->config = $this->getInvokeArg('bootstrap')->getOption('user');
    }

    /**
     * Action
     */
    public function indexAction()
    {
        // Check config for register form class name
        if (!empty($this->config['classRegisterForm'])) {
            $formClass = $this->config['classRegisterForm'];

            // Default is User_Form_RegisterForm
        } else {
            $formClass = 'User_Form_RegisterForm';
        }

        // Set the view script path from the config if it exists
        if (!empty($this->config['pathViewRegister'])) {
            $this->view->setScriptPath(APPLICATION_PATH . $this->config['pathViewRegister']);
        }

        // Instantiate the form and pass this to the view
        $this->view->form = new $formClass();

        // Check for a POST in the request
        if ($this->_request->isPost()) {

            // Check that the form is valid
            if ($this->view->form->isValid($_POST)) {

                // Check to see if there is a site specific registration class
                if ($this->config['classRegisterValidate']) {

                    // Process the Registration using the Site Class
                    $className = $this->config['classRegisterValidate'];
                    $validate = new $className();
                    $validate->register();

                    // Else validate the default registration form
                } else {

                }

                // If form validation fails populate and display the form again
            } else {
                $this->view->form->populate($_POST);
            }
        }
    }

    /**
     * Method to display the registration form.
     *
     * @return object
     */
    public function completeAction()
    {
        // Set the view script path from the config if it exists
        if ($this->config['pathViewRegister']) {
            $this->view->addScriptPath($this->config['pathViewRegister']);
        }

        // Set up the default message
        $this->view->messageText = 'Your account has been created, please check your email for the validation email. Make
                                     sure this has not gone into the Junk / Spam box also. Follow the instructions in this
                                     email to activate your account.';
        $this->view->messageTitle = 'Account Created';
        $this->view->messageType = 'msgSuccess';
    }

    /**
     * Method to validate a user account when clicking through from an email
     *
     * @return void
     */
    public function validateAction()
    {
        // Set the view script path from the config if it exists
        if ($this->config['pathViewRegister']) {
            $this->view->addScriptPath($this->config['pathViewRegister']);
        }

        // Query to update a user status based on the hash received
        $table = new Default_Model_DbTable_User();
        $data = array('type' => 'authenticated', 'status' => 'Active');
        $where = array($table->getAdapter()->quoteInto('hash = ?', $this->_getParam('hash')));
        $result = $table->update($data, $where);

        // Send the result through to the view
        $this->view->result = $result;
    }

}
