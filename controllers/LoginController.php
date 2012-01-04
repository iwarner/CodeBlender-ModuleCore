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
class Core_LoginController extends Zend_Controller_Action
{

    /**
     * Action
     */
    public function preDispatch()
    {
        // Auth Instance
        $auth = Zend_Auth::getInstance();

        // Config
        $this->config = $this->getInvokeArg('bootstrap')->getOption('user');

        // User logged in
        if ($auth->hasIdentity()) {

            // Redirect the User
            $this->_helper->getHelper('Redirector')->gotoUrl($this->config['pathLoginSuccess']);
        }
    }

    /**
     * Action
     */
    public function indexAction()
    {
        // Get the class name / path for the login form to use default is
        // Core_Form_LoginForm - Instantiate Form.
        if (!empty($this->config['classLoginForm'])) {
            $formClass = $this->config['classLoginForm'];
        } else {
            $formClass = 'Core_Form_LoginForm';
        }

        // Set the view script path from the config if it exists
        if (!empty($this->config['pathViewLogin'])) {
            $this->view->setScriptPath(APPLICATION_PATH . $this->config['pathViewLogin']);
        }

        // Instantiate the form and pass this to the view
        $this->view->form = new $formClass();

        // Check for a POST
        if ($this->_request->isPost()) {

            if ($this->view->form->isValid($_POST)) {

                // Verify the user exists in the database
                $login = self::_verifyUser($this->_getParam('email'), $this->_getParam('password'));

                // See if login was successful and show the correct text.
                if ($login) {
                    // Redirect to the Index Action - default/index/complete
                    $this->_helper->redirector->gotoUrl($this->config['pathLoginSuccess']);
                } else {
                    $this->view->messageType = 'error';
                    $this->view->messageTitle = 'Login Failure';
                    $this->view->messageText = 'Login Failed, please try again make sure Caps Lock is not on.
                      Your account may still need validation; please check your email.';
                }
            } else {

                // If form validation fails populate and display the form again
                $this->view->form->populate($_POST);
            }
        }

//        $this->_helper->layout->setPartial('login');
////        $this->_helper->layout->setLayout('login');
    }

    /**
     * Auth Adaptor
     *
     * @return object
     */
    private function _getAuthAdaptor()
    {
        $table = 'user';

        // Set up Table
        if (isset($this->config['memberTable'])) {
            $table = $this->config['memberTable'];
        }

        // Instantiate the DbTable auth Adapter and set credentials Make sure status is Active also
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName($table)
            ->setIdentityColumn('email')
            ->setCredentialColumn('password')
            ->setCredentialTreatment('MD5(?) AND status = "Active"');

        return $authAdapter;
    }

    /**
     * Verify the login credentials
     *
     * Uses the Database Adaptor
     *
     * @param  string $email    User email address
     * @param  string $password User password
     * @return boolean
     */
    private function _verifyUser($email, $password)
    {
        // Check that email and password exist and they are not empty
        if (!empty($email) && !empty($password)) {

            // Get the Auth Adaptor
            $authAdapter = self::_getAuthAdaptor();

            // Set the details through the AuthAdaptor
            $authAdapter->setIdentity($email)
                ->setCredential($password);

            // Get an instance of Zend Auth
            $auth = Zend_Auth::getInstance();

            // Use 'someNamespace' instead of 'Zend_Auth' created from SiteName
            $auth->setStorage(new Zend_Auth_Storage_Session(CODEBLENDER_SITENAME));

            // Perform the authentication query, saving the result
            try {
                $result = $auth->authenticate($authAdapter);
            } catch (Zend_Exception $e) {
                Zend_Debug::dump($e->getMessage());
            }

            // If a result is found then the
            if (isset($result) && $result->isValid()) {

                // Store the identity as an object where only the username and real_name have been returned
                $auth->getStorage()->write($authAdapter->getResultRowObject(array('id', 'type', 'email', 'fname', 'sname')));

                // Check to see if the Remember me Checkbox was Set
                if ($this->_getParam('loginRememberMe')) {

                    // Set to remember this user for 1 day
                    Zend_Session::rememberMe($this->config['rememberMe']);
                }

                return true;

                // Cant find a user that matches these user and pass combination
                // Clear the identiy and return false
            } else {
                $auth->clearIdentity();
                return false;
            }
        } else {
            return false;
        }
    }

}
