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
        // Translation
        $translate = Zend_Registry::get('Zend_Translate');

        // Form Attributes
        $this->setName('loginForm')
            ->setAction('/core/login')
            ->setMethod('post');

        // Email
        $this->addElement('text', 'email', array(
            'filters' => array('StringToLower'),
            'label' => $translate->_('loginEmail'),
            'required' => true,
            'validators' => array('EmailAddress')
        ));

        // Password
        $this->addElement('password', 'password', array(
            'label' => $translate->_('loginPassword'),
            'required' => true,
            'validators' => array(array('regex', false, array('/^[a-zA-Z0-9_=]{6,20}$/i')))
        ));

        $this->addElement('checkbox', 'rememberMe', array(
            'class' => 'rememberMe',
            'label' => $translate->_('loginRemember'),
            'checkedValue' => true,
            'uncheckedValue' => false,
            'value' => false
        ));

        $this->rememberMe->setDescription('Forgot Details');

        // Submit
        $this->addElement('submit', 'submit', array(
            'class' => 'button-primary',
            'ignore' => true,
            'label' => $translate->_('loginLogIn'),
            'required' => false
        ));

        // Filters
        $this->setElementFilters(array('StringTrim', 'StripTags'));
        $this->setElementDecorators(array(
            'ViewHelper',
            'Errors',
            'Label',
            'Description'
        ));

        $this->rememberMe->addDecorator('Label', array('class' => 'rememberMeLabel'));
        $this->submit->removeDecorator('Label');
        $this->setDecorators(array(array('ViewScript', array('viewScript' => '/login/loginForm.phtml'))));
    }

}
