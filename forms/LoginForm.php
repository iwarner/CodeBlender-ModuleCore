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
class Core_Form_LoginForm extends Zend_Form
{

    /**
     * Init
     */
    public function init()
    {
        // Form Attributes
        $this->setName('loginForm')
                ->setAction('/user/login')
                ->setMethod('post');

        // Email
        $this->addElement('text', 'email', array(
            'filters' => array('StringToLower'),
            'label' => 'Email',
            'required' => true,
            'validators' => array('EmailAddress')
        ));

        // Password
        $this->addElement('password', 'password', array(
            'label' => 'Password',
            'required' => true,
            'validators' => array(array('regex', false, array('/^[a-zA-Z0-9_=]{6,20}$/i')))
        ));

        $this->addElement('checkbox', 'rememberMe', array(
            'class' => 'rememberMe',
            'label' => 'Remember Me',
            'checkedValue' => true,
            'uncheckedValue' => false,
            'value' => false
        ));

        // Submit
        $this->addElement('submit', 'submit', array(
            'class' => 'button-primary',
            'ignore' => true,
            'label' => 'Log In',
            'required' => false
        ));

        // Filters
        $this->setElementFilters(array('StringTrim', 'StripTags'));
        $this->setElementDecorators(array(
            'ViewHelper',
            'Errors',
            'Label'
        ));

        $this->rememberMe->addDecorator('Label', array('class' => 'rememberMeLabel'));
        $this->submit->removeDecorator('Label');
        $this->setDecorators(array(array('ViewScript', array('viewScript' => '/login/loginForm.phtml'))));
    }

}
