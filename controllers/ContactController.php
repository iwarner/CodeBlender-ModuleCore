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
 */
class Core_ContactController extends Zend_Controller_Action
{

    /**
     * Action
     */
    public function indexAction()
    {
        // Config
        $config = $this->getInvokeArg('bootstrap')->getOption('core');

        // Set the view script path from the config if it exists
        if (!empty($config['pathViewContact'])) {
            $this->view->setScriptPath(APPLICATION_PATH . $config['pathViewContact']);
        }

        // Render Contact Form
        $this->view->form = $form = new Core_Form_ContactForm();

        if (APPLICATION_ENV == 'development') {
            $form->populate(array(
                'name' => 'Test Email',
                'email' => 'iwarner_uk@yahoo.co.uk',
                'phone' => '0798673933',
                'comment' => 'Test Development Email',
                'subject' => 'Comments'
            ));
        }

        // Check to see if this controller receives a POST
        if ($this->getRequest()->isPost()) {

            // Check to see if the form is Valid
            if (!$form->isValid($_POST)) {

                // Send an email to the Site Owner
            } else {

                $values = $form->getValues();
                $values['ip'] = $_SERVER['REMOTE_ADDR'];

                $text = 'Name: ' . $values['name'] . PHP_EOL;
                $text .= 'Email: ' . $values['email'] . PHP_EOL;
                $text .= 'Phone: ' . $values['phone'] . PHP_EOL;
                $text .= 'Subject: ' . $values['subject'] . PHP_EOL;
                $text .= 'Comments: ' . $values['comment'] . PHP_EOL . PHP_EOL;
                $text .= 'REMOTE_ADDR: ' . $_SERVER['REMOTE_ADDR'] . PHP_EOL;
                $text .= 'HTTP_USER_AGENT: ' . $_SERVER['HTTP_USER_AGENT'] . PHP_EOL;
                $text .= 'HTTP_REFERER: ' . $_SERVER['HTTP_REFERER'] . PHP_EOL;

                $html = 'Name: ' . $values['name'] . '<br />';
                $html .= 'Email: ' . $values['email'] . '<br />';
                $html .= 'Phone: ' . $values['phone'] . '<br />';
                $html .= 'Subject: ' . $values['subject'] . '<br />';
                $html .= 'Comments: ' . $values['comment'] . '<br /><br /><br />';
                $html .= 'REMOTE_ADDR: ' . $values['ip'] . '<br />';
                $html .= 'HTTP_USER_AGENT: ' . $_SERVER['HTTP_USER_AGENT'] . '<br />';
                $html .= 'HTTP_REFERER: ' . $_SERVER['HTTP_REFERER'] . '<br />';

                $params = array(
                    'emailTo' => array('iwarner@triangle-solutions.com' => 'Triangle'),
                    'emailFrom' => array($values['email'], $values['name']),
                    'subject' => CODEBLENDER_SITENAME . ' ' . $values['subject'],
                    'textHTML' => $html,
                    'textPlain' => $text
                );

                $mail = $this->_helper->getHelper('Mail')->sendMail($params);

                // Check to see if there is a Comment Model
                if (Zend_Loader_Autoloader::autoload('Default_Model_DbTable_Comment')) {

                    // Remove the captcha value
                    unset($values['captcha']);

                    // Save the comment into the database
                    $table = new Default_Model_DbTable_Comment();
                    $result = $table->insert($values);
                }

                // Render Form
                $this->view->valid = true;
            }
        }
    }

}
