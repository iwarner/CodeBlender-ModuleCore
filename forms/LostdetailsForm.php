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
 * Form
 *
 * @category  CodeBlender
 * @package   Core
 * @copyright Copyright (c) 2011 Triangle Solutions Ltd. (http://www.triangle-solutions.com/)
 * @license   http://codeblender.net/license
 */
class Core_Form_LostDetailsForm extends Zend_Form
{

    /**
     * Init
     */
    public function init()
    {
        // Invoke the config argument
        $config = Zend_Registry::get('config');

        // Set ID of the form
        $this->setName('lostDetailsForm')
                ->setAction('/user/forgotdetails')
                ->setMethod('post');

        $this->addElement('ValidationTextBox', 'lostDetailsEmail', array(
            'filters' => array('StringTrim', 'StringToLower'),
            'invalidMessage' => 'Invalid Email',
            'label' => 'Email',
            'required' => true,
            'trim' => true,
            'validators' => array('EmailAddress', array('StringLength', false, 4))
        ));

        $this->addElement('Captcha', 'contactCaptcha', array(
            'captcha' => 'ReCaptcha',
            'captchaOptions' => array(
                'privKey' => $config->recaptcha->privateKey,
                'pubKey' => $config->recaptcha->publicKey)
        ));

        $this->contactCaptcha->addDecorators(array(
            array('HtmlTag', array('tag' => 'dd', 'style' => 'padding-left: 85px; padding-bottom: 10px;'))
        ));

        $this->addElement('submitButton', 'lostDetailsSubmit', array(
            'ignore' => true,
            'label' => 'Submit',
            'required' => false
        ));

        $this->lostDetailsSubmit->addDecorators(array(
            array('HtmlTag', array('tag' => 'div', 'class' => 'submit'))
        ));

        $this->addDisplayGroup(
                array('lostDetailsEmail', 'lostDetailCaptcha', 'lostDetailsSubmit'), 'credentials', array('legend' => 'Submit Account Email Address')
        );

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'div')),
            'Form'
        ));
    }

}
