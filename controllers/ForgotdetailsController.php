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
class Core_ForgotdetailsController extends Zend_Controller_Action
{

    /**
     * Action
     */
    public function indexAction()
    {
        // Config
        $config = $this->getInvokeArg('bootstrap')->getOption('user');

        // Set the view script path from the config if it exists
        if ($config['pathViewLost']) {
            $this->view->setScriptPath(APPLICATION_PATH . $config['pathViewLost']);
        }

        // Render Form
        $this->view->form = new User_Form_LostdetailsForm();

        // Check to see if this controller receives a POST
        if ($this->getRequest()->isPost()) {

            // Check to see if the form is Valid
            if (!$this->view->form->isValid($_POST)) {

                // Send an email to the Site Owner
            } else {

                $values = $this->view->form->getValues();

                // Query to check whether the email is valid
                $table = new Default_Model_DbTable_User();
                $where = array('email = ?' => $values['lostDetailsEmail']);
                $rowSet = $table->fetchAll($where);
                $row = $rowSet->current();

                // Check that a result was returned
                if (count($rowSet) >= 1) {

                    $siteName = CODEBLENDER_SITENAME;
                    $name = $row->fname . '' . $row->sname;

                    $text = "Dear " . $name . "\r\n";
                    $text .= "Below are the requested Account Details.\r\n\r\n";
                    $text .= "Email: " . $row->email . "\t\r\n";
                    $text .= "Password: " . $row->password . "\r\n\t\r\n";
                    $text .= "Kind Regards\r\n";
                    $text .= $siteName . "\r\n\r\n\r\n";
                    $text .= 'REMOTE_ADDR: ' . $_SERVER['REMOTE_ADDR'] . "\r\n";
                    $text .= 'HTTP_USER_AGENT: ' . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
                    $text .= 'HTTP_REFERER: ' . $_SERVER['HTTP_REFERER'] . "\r\n";

                    $html = "Dear " . $name . "<br />";
                    $html .= "Below are the requested Account Details.<br /><br />";
                    $html .= "Email: " . $row->email . "<br />";
                    $html .= "Password: " . $row->password . "<br /><br />";
                    $html .= "Kind Regards<br />";
                    $html .= $siteName . "<br /><br /><br />";
                    $html .= 'REMOTE_ADDR: ' . $_SERVER['REMOTE_ADDR'] . "<br />";
                    $html .= 'HTTP_USER_AGENT: ' . $_SERVER['HTTP_USER_AGENT'] . "<br />";
                    $html .= 'HTTP_REFERER: ' . $_SERVER['HTTP_REFERER'] . "<br />";

                    $params = array(
                        'emailTo' => $row->email,
                        'emailToName' => $name,
                        'subject' => $siteName . ' details request',
                        'textHTML' => $html,
                        'textPlain' => $text
                    );

                    $mail = $this->_helper->getHelper('Mail')->sendMail($params);

                    $this->view->messageType = 'msgSuccess';
                    $this->view->messageTitle = 'Email Sent';
                    $this->view->messageText = 'Your account details have been sent to the email given.';
                } else {
                    $this->view->messageType = 'msgError';
                    $this->view->messageTitle = 'Account Not Found';
                    $this->view->messageText = 'Sorry no account was found with the email you have submitted, please try again.';
                }

                // Render Form
                $this->view->valid = true;
            }
        }
    }

}
