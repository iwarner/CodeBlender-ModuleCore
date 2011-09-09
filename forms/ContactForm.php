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
 * Form
 *
 * @category  CodeBlender
 * @package   Core
 * @copyright Copyright (c) 2000-2011 Triangle Solutions Ltd. (http://www.triangle-solutions.com/)
 * @license   http://codeblender.net/license
 */
class Core_Form_ContactForm extends Zend_Form
{

    /**
     * Form
     */
    public function init()
    {
        // Config
        $config = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('recaptcha');

        // Set Properties of the form
        $this->setName('contactForm');

        // Display the Details Group
        $this->addElement('text', 'name', array(
            'label' => 'Name',
            'required' => true,
            'validators' => array(array('Alnum', false, true))
        ));

        $this->addElement('text', 'email', array(
            'filters' => array('StringToLower'),
            'label' => 'Email',
            'required' => true,
            'validators' => array('EmailAddress')
        ));

        $this->addElement('text', 'phone', array(
            'label' => 'Phone',
            'required' => true,
            'validators' => array('Digits')
        ));

        $this->addElement('Textarea', 'comment', array(
            'label' => 'Comments',
            'required' => true,
            'cols' => 25,
            'rows' => 8
        ));

        $this->addElement('Select', 'subject', array(
            'multiOptions' => array('Questions' => 'Questions', 'Comments' => 'Comments', 'Webmaster' => 'Webmaster', 'Advertising' => 'Advertising'),
            'label' => 'Subject',
            'required' => true,
            'validators' => array('Alpha')
        ));

        $this->addElement('Captcha', 'captcha', array(
            'captcha' => 'ReCaptcha',
            'captchaOptions' => array(
                'privKey' => $config['privateKey'],
                'pubKey' => $config['publicKey'])
        ));

        $this->addElement('Submit', 'submit', array(
            'label' => 'Submit',
            'class' => 'submit'
        ));

        $this->setElementFilters(array('StringTrim', 'StripTags'));
    }

}
